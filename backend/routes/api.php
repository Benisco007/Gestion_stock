<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\CompanySettingController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Matériels
    Route::apiResource('materials', MaterialController::class);

    // Paramètres entreprise
    Route::get('/settings', [CompanySettingController::class, 'show']);
    Route::post('/settings', [CompanySettingController::class, 'upsert']);
});
