<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('sign')->group(function () {
    Route::post('in', [AuthController::class, 'in']);
    Route::post('up', [AuthController::class, 'up']);
    Route::post('out', [AuthController::class, 'out']);
});

Route::delete('/product/delete-image/{productImage}', [ProductController::class, 'deleteImage']);
Route::apiResource('product', ProductController::class);
Route::apiResource('/store', StoreController::class);
