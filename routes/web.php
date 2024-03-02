<?php

use App\Http\Controllers\WEB\DashboardController;
use App\Http\Controllers\WEB\User\AdminController;
use App\Http\Controllers\WEB\User\CourierController;
use App\Http\Controllers\WEB\User\CustomerController;
use App\Http\Controllers\WEB\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::name('web.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard.index');

    Route::get('/user', UserController::class)->name('user.index');
    Route::resource('/user/admin', AdminController::class, ["as" => "user"]);
    Route::resource('/user/customer', CustomerController::class, ["as" => "user"]);
    Route::resource('/user/courier', CourierController::class, ["as" => "user"]);
});
