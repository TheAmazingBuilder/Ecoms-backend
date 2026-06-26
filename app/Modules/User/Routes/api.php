<?php

use App\Modules\User\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('users', UserController::class);
});
