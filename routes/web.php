<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return "Welcome Admin!";
    });
});

Route::middleware(['auth', 'role:farmer'])->group(function () {
    Route::get('/farmer', function () {
        return "Welcome Farmer!";
    });
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer', function () {
        return "Welcome Customer!";
    });
});