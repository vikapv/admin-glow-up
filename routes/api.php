<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\CartApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Продукты
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/{id}', [ProductApiController::class, 'show']);
Route::post('/products', [ProductApiController::class, 'store']);

// Профиль / Пользователь
Route::get('/user', [ProfileApiController::class, 'user']);
Route::post('/user/update', [ProfileApiController::class, 'updateUser']);


Route::get('/addresses', [ProfileApiController::class, 'addresses']);
Route::post('/addresses', [ProfileApiController::class, 'addAddress']);
Route::delete('/addresses/{id}', [ProfileApiController::class, 'deleteAddress']);

Route::get('/bonuses', [ProfileApiController::class, 'bonuses']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/cart', [CartApiController::class, 'index']);
    Route::post('/cart/add', [CartApiController::class, 'add']);
    Route::post('/cart/update/{id}', [CartApiController::class, 'update']);
    Route::delete('/cart/remove/{id}', [CartApiController::class, 'remove']);
    
    Route::get('/orders', [ProfileApiController::class, 'orders']);
});
