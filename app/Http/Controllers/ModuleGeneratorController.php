<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreModuleGeneratorRequest;
use App\Services\ModuleGeneratorService;
use Nwidart\Modules\Facades\Module;

class ModuleGeneratorController extends Controller
{
    /**
     * @var ModuleGeneratorService
     */
    private ModuleGeneratorService $moduleGeneratorService;

    /**
     * @param ModuleGeneratorService $moduleGeneratorService
     */
    public function __construct(ModuleGeneratorService $moduleGeneratorService)
    {
        $this->middleware(['auth', 'verified', 'password.confirm']);
        $this->moduleGeneratorService = $moduleGeneratorService;
    }

    /**
     * @return View|Factory|Application
     */
    public function create(): View|Factory|Application
    {
        $modules = Module::all();
        return view('module-generator', compact('modules'));
    }

    /**
     * @param StoreModuleGeneratorRequest $request
     * @return RedirectResponse
     */
    public function store(StoreModuleGeneratorRequest $request): RedirectResponse
    {
        $sanitized = $request->getSanitized();

        $this->moduleGeneratorService->generate($sanitized['module'], $sanitized['model']);

        return redirect()->route('module-generator.create')
            ->with('success', 'Module created successfully.');
    }
}
