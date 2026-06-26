<?php

use App\Modules\Cart\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('cart', [CartController::class, 'show']);
    Route::post('cart/items', [CartController::class, 'addItem']);
    Route::put('cart/items/{itemId}', [CartController::class, 'updateItem']);
    Route::delete('cart/items/{itemId}', [CartController::class, 'removeItem']);
    Route::delete('cart', [CartController::class, 'clear']);
});
