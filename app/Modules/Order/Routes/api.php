<?php

use App\Modules\Order\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('orders', [OrderController::class, 'index']);
    Route::post('orders', [OrderController::class, 'store']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
    Route::patch('orders/{id}/status', [OrderController::class, 'updateStatus']);
    Route::patch('orders/{id}/cancel', [OrderController::class, 'cancel']);
});
