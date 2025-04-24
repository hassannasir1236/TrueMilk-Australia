<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\FarmInventoryController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StateDashboardController;
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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:admin,manager,farmer'])->group(function () {

    // Add Farms Routes
    Route::get('/farms', [FarmController::class, 'index'])->name('farms.index');
    Route::post('/farms/store', [FarmController::class, 'saveFarm'])->name('farms.store');
    Route::delete('/farms/{id}', [FarmController::class, 'deleteFarm'])->name('farms.destroy');
    Route::get('/farms/{id}/edit', [FarmController::class, 'edit'])->name('farms.edit');

    // Add Farms Inventory Routes
    Route::get('/farm-inventory', [FarmInventoryController::class, 'index'])->name('farm-inventory.index');
    Route::post('/farm-inventory/store', [FarmInventoryController::class, 'store'])->name('farm-inventory.store');
    Route::get('/farm-inventory/edit/{id}', [FarmInventoryController::class, 'edit'])->name('farm-inventory.edit');
    Route::delete('/farm-inventory/delete/{id}', [FarmInventoryController::class, 'destroy'])->name('farm-inventory.destroy');

    // for loading farms by state
    Route::get('/farms/by-state/{state_id}', [FarmInventoryController::class, 'getFarmsByState']);

    // state dashboard
    Route::get('/state-dashboard/{state?}', [StateDashboardController::class, 'index'])->name('state.dashboard');

    // Setting page routes
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/settings/update', [SettingController::class, 'updateSettings'])->name('settings.update');

});