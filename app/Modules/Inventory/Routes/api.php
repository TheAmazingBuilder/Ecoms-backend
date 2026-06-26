<?php

use App\Modules\Inventory\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('inventories', [InventoryController::class, 'index']);
    Route::get('inventories/{id}', [InventoryController::class, 'show']);
    Route::patch('inventories/{id}/adjust', [InventoryController::class, 'adjust']);
});
