<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleGeneratorController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
  return redirect()->route('dashboard');
})->name('index');

Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

if(env('APP_ENV') === 'local') {
  Route::resource('/module-generator', ModuleGeneratorController::class, ['only' => ['create', 'store']]);
}

Auth::routes(['verify' => true]);


