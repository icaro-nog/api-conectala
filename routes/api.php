<?php

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){

    Route::post('users/', [UserController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('users/', [UserController::class, 'index']);
        Route::get('users/{user}', [UserController::class, 'show']);
        Route::put('users/{user}', [UserController::class, 'update']);
        Route::delete('users/{user}', [UserController::class, 'destroy']);
        Route::post('logout/', [AuthController::class, 'logout']);

    });
    
    Route::post('/login', [AuthController::class, 'login']);
    
});
