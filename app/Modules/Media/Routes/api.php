<?php

use App\Modules\Media\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::post('media', [MediaController::class, 'store']);
    Route::delete('media/{id}', [MediaController::class, 'destroy']);
});
