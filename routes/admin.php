<?php

use Illuminate\Support\Facades\Route;

// Login
Route::post('auth/login', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'login'])->middleware('guest');

// Auth routes
Route::middleware('auth:sanctum')->group(function () {
    // Profile
    Route::get('auth/profile', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'profile']);
    // Logout
    Route::post('auth/logout', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'logout']);

    // User routes
    Route::prefix('user')->controller(\App\Http\Controllers\Admin\UserController::class)->group(function () {
        Route::get('', 'index');
        Route::get('{user}', 'show');
        Route::post('', 'create');
        Route::post('update', 'update');
        Route::delete('{user}', 'destroy');
    });

    // Role routes
    Route::prefix('role')->controller(\App\Http\Controllers\Admin\RoleController::class)->group(function () {
        Route::get('', 'index');
        Route::get('permissions', 'permissions');
        Route::get('{role}', 'show');
        Route::post('', 'create');
        Route::post('{role}', 'update');
        Route::delete('{role}', 'destroy');
    });

    // Employee routes
    Route::prefix('employees')->group(function () {

        // Attendance routes
        Route::prefix('attendance')->controller(\App\Http\Controllers\Admin\employee\AttendanceController::class)->group(function () {
            Route::get('', 'index');
            Route::get('all', 'all');
            Route::get('check-in', 'checkIn');
            Route::get('check-out', 'checkOut');
        });

        Route::prefix('leave-requests')->controller(\App\Http\Controllers\Admin\employee\LeaveRequestController::class)->group(function () {
            Route::get('', 'index');
            Route::get('all', 'all');
            Route::post('change-status', 'changeStatus');
            Route::post('', 'store');
            Route::post('{LeaveRequest}', 'update');
            Route::delete('{LeaveRequest}', 'destroy');
        });

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
            Route::delete('{task}', 'destroy');
            Route::post('order', 'order');
        });

        // task routes
        Route::prefix('task')->group(function () {
            Route::controller(\App\Http\Controllers\Admin\Project\Task\TaskController::class)->group(function () {
                Route::get('{section_id}', 'index');
                Route::get('employees/{project}', 'employees');
                Route::get('show/{task_id}', 'show');
                Route::post('order', 'order');
                Route::post('create', 'create');
                Route::post('update', 'update');
                Route::delete('{task}', 'delete');
            });

            // Comment routes
            Route::prefix('comment')->controller(\App\Http\Controllers\Admin\Project\Task\CommentController::class)->group(function () {
                Route::post('', 'create');
                Route::post('{taskComment}', 'update');
                Route::delete('file/{taskCommentFile}', 'deleteFile');
                Route::get('file/{taskCommentFile}', 'downloadFile');
            });

            // Checklist routes
            Route::prefix('checklist')->controller(\App\Http\Controllers\Admin\Project\Task\ChecklistController::class)->group(function () {
                Route::post('', 'create');
                Route::post('{taskChecklist}', 'update');
                Route::post('complete/{taskChecklist}', 'complete');
                Route::delete('{taskChecklist}', 'destroy');
            });
        });

    });

    Route::prefix('website')->group(function () {
        // Hero routes
        Route::get('hero', [\App\Http\Controllers\Admin\Website\HeroController::class, 'index']);
        Route::post('hero', [\App\Http\Controllers\Admin\Website\HeroController::class, 'update']);
    });
});
