<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Login
Route::post('auth/login', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'login'])->middleware('guest');

// Auth routes
Route::middleware('auth:sanctum')->group(function () {
    // Profile
    Route::get('auth/profile', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'profile']);
    // Logout
    Route::post('auth/logout', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'logout']);

    // Employee routes
    Route::prefix('employees')->group(function () {
        // Employment status routes
        Route::get('status', [\App\Http\Controllers\Admin\Employee\EmploymentStatusController::class, 'index']);

        // Employment jobs routes
        Route::controller(\App\Http\Controllers\Admin\Employee\EmployeeJobController::class)->prefix('job')->group(function () {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::get('{employee_job}', 'show');
            Route::post('{employee_job}', 'update');
            Route::delete('{employee_job}', 'destroy');
        });

        // employed routes
        Route::controller(\App\Http\Controllers\Admin\Employee\EmployeeController::class)->group(function () {
            Route::get('', 'index');
            Route::get('{employee}', 'show');
            Route::post('', 'create');
            Route::post('{employee}', 'update');
            Route::delete('{employee}', 'destroy');
        });
    });
});
