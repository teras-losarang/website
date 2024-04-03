<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\FavoriteController;
use App\Http\Controllers\API\ModulController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\PurchaseController;
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

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('me', [AuthController::class, 'me']);
        Route::post('out', [AuthController::class, 'out']);
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('modul', ModulController::class);

    Route::post('product/favorite/{id}', [ProductController::class, 'favorite']);
    Route::delete('product/delete-image/{productImage}', [ProductController::class, 'deleteImage']);
    Route::apiResource('product', ProductController::class);

    Route::apiResource('cart', CartController::class);

    Route::get('store/search', [StoreController::class, 'search']);
    Route::apiResource('store', StoreController::class);
    Route::apiResource('favorite', FavoriteController::class);
    Route::apiResource('purchase', PurchaseController::class);
    Route::apiResource('order', OrderController::class);
});
