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
        // Loans routs
        Route::prefix('loan')->controller(\App\Http\Controllers\Admin\Employee\LoanController::class)->group(function () {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::delete('{loan}', 'destroy');
        });

        // Loans routs
        Route::prefix('transaction')->controller(\App\Http\Controllers\Admin\Employee\TransactionController::class)->group(function () {
            Route::get('', 'index');
            Route::get('{transaction}', 'show');
            Route::post('', 'store');
            Route::post('{transaction}', 'update');
            Route::delete('{transaction}', 'destroy');
        });

        // Payroll routs
        Route::prefix('payrolls')->controller(\App\Http\Controllers\Admin\Employee\PayrollController::class)->group(function () {
            Route::get('', 'index');
            Route::post('{payroll}', 'markAsPaid');
        });

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

    // Project management routes
    Route::prefix('projects')->group(function () {

        // Client routes
        Route::prefix('client')->controller(\App\Http\Controllers\Admin\Project\ClientController::class)->group(function () {
            Route::get('', 'index');
            Route::post('', 'create');
            Route::get('{client}', 'show');
            Route::post('{client}', 'update');
            Route::delete('{client}', 'destroy');
        });

        // Projects routes
        Route::controller(\App\Http\Controllers\Admin\Project\ProjectController::class)->group(function () {
            Route::get('', 'index');
            Route::get('users', 'users');
            Route::get('employees', 'employees');
            Route::get('', 'index');
            Route::post('update-status-order', 'updateStatusAndOrder');
            Route::get('{project}', 'show');
            Route::post('{project}', 'update');
            Route::post('', 'create');
            Route::delete('{project}', 'destroy');
        });

        // Section routes
        Route::prefix('section')->controller(\App\Http\Controllers\Admin\Project\SectionController::class)->group(function () {
            Route::get('{project}/dropdown', 'dropdown');
            Route::get('{project}', 'index');
            Route::post('create', 'create');
            Route::post('update', 'update');
            Route::delete('{section}', 'destroy');
            Route::post('order', 'order');
        });

    });
});
