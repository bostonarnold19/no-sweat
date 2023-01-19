<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use App\Exceptions\ModuleGeneratorException;

class ModuleGeneratorService
{
    /**
     * @var string
     */
    public string $module = '';

    /**
     * @var string
     */
    public string $model = '';

    /**
     * @var string
     */
    public string $table = '';

    /**
     * @param string $module
     * @param string $model
     * @return true
     * @throws ModuleGeneratorException
     */
    public function generate(string $module, string $model): bool
    {
        $this->initializeProperties($module, $model);
        $this->checkModelIfExist();

        if(!$this->checkModuleIfExist()) {
            Artisan::call("module:make {$this->module}");

            $this->removeInitialController();
            $this->removeInitialSeeder();
            $this->removeInitialServiceProvider();
            $this->createServiceProvider();
        }

        $this->createModel();
        $this->createRequest();
        $this->createPolicy();
        $this->createController();
        $this->createViews();
        $this->updateRoute();
        $this->createMigration();

        return true;
    }

    /**
     * @param $module
     * @param $model
     * @return void
     */
    private function initializeProperties($module, $model): void
    {
        $this->module = $this->pascalCase($module);
        $this->model = $this->pascalCase($model);
        $this->table = $this->snakeCase(Str::plural($this->model));
    }

    /**
     * @return void
     */
    private function createMigration(): void
    {
        Artisan::call("make:migration create_{$this->table}_table");
    }

    /**
     * @return bool
     */
    private function checkModuleIfExist(): bool
    {
        return Module::collections()->has($this->module);
    }

    /**
     * @return void
     * @throws ModuleGeneratorException
     */
    private function checkModelIfExist(): void
    {
        $modelPath = 'Modules\\' . $this->module . '\Entities\\' . $this->model;

        if (class_exists($modelPath)) {
            throw new ModuleGeneratorException("ERROR: Model already exist.");
        }
    }

    /**
     * @return false|string
     */
    private function getWebRouteFile(): bool|string
    {
        return file_get_contents(base_path()."/Modules/{$this->module}/Routes/web.php");
    }

    /**
     * @return void
     */
    private function updateRoute(): void
    {
        $file = $this->getWebRouteFile();
        $codeToAppend = "\t" . "Route::resource('{{ROUTE}}', '{{MODEL}}Controller');" . "\n";

        $codeToAppend = str_replace(
            [
                '{{MODEL}}',
                '{{ROUTE}}',
            ],
            [
                $this->model, //{{MODEL}}
                Str::plural($this->kebabCase($this->model)), //{{ROUTE}}
            ],
            $codeToAppend
        );

        $searchKey = "/module-generator/";
        preg_match($searchKey, $file, $matches, PREG_OFFSET_CAPTURE);
        $firstLinePosition = strlen($matches[0][0]) + $matches[0][1] + 1;
        $newFile = substr_replace($file, $codeToAppend, $firstLinePosition, 0);
        file_put_contents(base_path()."/Modules/{$this->module}/Routes/web.php", $newFile);
    }

    /**
     * @return void
     */
    private function createController(): void
    {
        $file = $this->getFileContent('controller');
        file_put_contents(base_path()."/Modules/{$this->module}/Http/Controllers/{$this->model}Controller.php", $file);
    }

    /**
     * @return void
     */
    private function createRequest(): void
    {
        $requestFiles = [
            'requests/destroy-request' => 'Destroy'.$this->model.'Request',
            'requests/index-request' => 'Index'.$this->model.'Request',
            'requests/store-request' => 'Store'.$this->model.'Request',
            'requests/update-request' => 'Update'.$this->model.'Request',
        ];

        $requestPath = base_path()."/Modules/{$this->module}/Http/Requests/{$this->model}";
        $this->makeDirectory($requestPath);

        foreach($requestFiles as $stub => $requestFile) {
            $file = $this->getFileContent($stub);
            file_put_contents($requestPath."/{$requestFile}.php", $file);
        }
    }

    /**
     * @return void
     */
    private function createPolicy(): void
    {
        $file = $this->getFileContent('policy');
        file_put_contents(base_path()."/Modules/{$this->module}/Policies/{$this->model}Policy.php", $file);
    }

    /**
     * @return void
     */
    private function createModel(): void
    {
        $file = $this->getFileContent('model');
        file_put_contents(base_path()."/Modules/{$this->module}/Entities/{$this->model}.php", $file);
    }

    /**
     * @return void
     */
    private function createServiceProvider(): void
    {
        $file = $this->getFileContent('service_provider');
        file_put_contents(base_path()."/Modules/{$this->module}/Providers/{$this->module}ServiceProvider.php", $file);
    }

    /**
     * @return void
     */
    private function createViews(): void
    {
        $viewFiles = [
            'views/create' => 'create',
            'views/edit' => 'edit',
            'views/form' => 'form',
            'views/index' => 'index',
            'views/show' => 'show',
        ];

        $viewPath = base_path()."/Modules/{$this->module}/Resources/views/{$this->kebabCase($this->model)}";
        $this->makeDirectory($viewPath);

        foreach($viewFiles as $stub => $viewFile) {
            $file = $this->getFileContent($stub);
            file_put_contents($viewPath."/{$viewFile}.blade.php", $file);
        }
    }

    /**
     * @param $stub
     * @return array|false|string|string[]
     */
    private function getFileContent($stub): array|bool|string
    {
        $search = [
            '{{MODEL}}',
            '{{MODULE}}',
            '{{VARIABLE_PLURAL}}',
            '{{VARIABLE}}',
            '{{ROUTE}}',
            '{{TITLE_PLURAL}}',
            '{{TITLE}}',
            '{{MODULE_VIEW}}',
            '{{MODEL_VIEW}}',
        ];

        $replace = [
            $this->model, //{{MODEL}}
            $this->module, //{{MODULE}}
            Str::plural(lcfirst($this->model)), //{{VARIABLE_PLURAL}}
            lcfirst($this->model), //{{VARIABLE}}
            Str::plural($this->kebabCase($this->model)), //{{ROUTE}}
            Str::plural(ucwords(trim($this->camelToSpace($this->model)))), //{{TITLE_PLURAL}}
            ucwords(trim($this->camelToSpace($this->model))), //{{TITLE}}
            $this->kebabCase($this->module), //{{MODULE_VIEW}}
            $this->kebabCase($this->model), //{{MODEL_VIEW}}
        ];

        $subject = $this->getStub($stub);

        return str_replace($search, $replace, $subject);
    }

    /**
     * @param $type
     * @return false|string
     */
    private function getStub($type): bool|string
    {
        return file_get_contents(base_path("stubs/custom-stubs/$type.stub"));
    }

    /**
     * @return void
     */
    private function removeInitialServiceProvider(): void
    {
        unlink(base_path()."/Modules/{$this->module}/Providers/{$this->module}ServiceProvider.php");
    }

    /**
     * @return void
     */
    private function removeInitialController(): void
    {
        unlink(base_path()."/Modules/{$this->module}/Http/Controllers/{$this->module}Controller.php");
    }

    /**
     * @return void
     */
    private function removeInitialSeeder(): void
    {
        unlink(base_path()."/Modules/{$this->module}/Database/Seeders/{$this->module}DatabaseSeeder.php");
    }

    /**
     * @param $path
     * @return void
     */
    private function makeDirectory($path): void
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    }

    /**
     * @param $string
     * @return array|string|string[]|null
     */
    private function pascalCase($string): array|string|null
    {
        return preg_replace('/\s+/', '', ucwords($string));
    }

    /**
     * @param $string
     * @return string
     */
    private function snakeCase($string): string
    {
        return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $string));
    }

    /**
     * @param $string
     * @return string
     */
    private function kebabCase($string): string
    {
        return strtolower(ltrim(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '-$0', $string), '-'));
    }

    /**
     * @param $string
     * @return string
     */
    private function camelToSpace($string): string
    {
        $pieces = preg_split('/(?=[A-Z])/', $string);
        return implode(" ", $pieces);
    }
}
