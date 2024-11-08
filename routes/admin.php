<?php

use Illuminate\Support\Facades\Route;

// Login
Route::post('auth/login', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'login'])->middleware('guest');

// Auth routes
Route::middleware('auth:sanctum')->group(function () {
    // Profile
    Route::get('auth/profile', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'profile']);
    Route::post('auth/profile', [\App\Http\Controllers\Admin\Auth\AuthController::class, 'updateProfile']);

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
                Route::delete('{taskCommentFile}', 'destroy');
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

        // Projects routes
        Route::controller(\App\Http\Controllers\Admin\Project\ProjectController::class)->group(function () {
            Route::get('', 'index');
            Route::get('users', 'users');
            Route::get('employees', 'employees');
            Route::post('update-status-order', 'updateStatusAndOrder');
            Route::get('/{project}', 'show');
            Route::post('/{project}', 'update');
            Route::post('/', 'create');
            Route::delete('/{project}', 'destroy');
        });

    });

    // Website routes
    Route::prefix('website')->group(function () {
        // Hero routes
        Route::get('hero', [\App\Http\Controllers\Admin\Website\HeroController::class, 'index']);
        Route::post('hero', [\App\Http\Controllers\Admin\Website\HeroController::class, 'update']);

        // Service section routes
        Route::apiResource('service/section', \App\Http\Controllers\Admin\Website\Service\ServiceSectionController::class)->only('index', 'store');
        // Service category routes
        Route::apiResource('service/category', \App\Http\Controllers\Admin\Website\Service\ServiceCategoryController::class);
        // Service feature routes
        Route::apiResource('service/feature', \App\Http\Controllers\Admin\Website\Service\ServiceFeatureController::class);
        // Service plane routes
        Route::apiResource('service/plane', \App\Http\Controllers\Admin\Website\Service\ServicePlaneController::class);
        // Service routes
        Route::apiResource('service', \App\Http\Controllers\Admin\Website\Service\ServiceController::class);

        // Project section routes
        Route::apiResource('project/section', \App\Http\Controllers\Admin\Website\Project\HomeProjectSectionController::class)->only('index', 'store');
        // Project category routes
        Route::apiResource('project/category', \App\Http\Controllers\Admin\Website\Project\HomeProjectCategoryController::class);
        // Project image routes
        Route::apiResource('project/image', \App\Http\Controllers\Admin\Website\Project\HomeProjectImageController::class)->only('destroy', 'store');
        // Project routes
        Route::apiResource('project', \App\Http\Controllers\Admin\Website\Project\HomeProjectController::class);

        // Brand routes
        Route::apiResource('brand', \App\Http\Controllers\Admin\Website\BrandController::class)->only('index', 'store', 'destroy');
        Route::post('brand/section', [\App\Http\Controllers\Admin\Website\BrandController::class, 'updateBrandSection']);

        // Why routes
        Route::apiResource('why', \App\Http\Controllers\Admin\Website\WhyController::class);
        Route::post('why/section', [\App\Http\Controllers\Admin\Website\WhyController::class, 'updateWhySection']);

        // Rate routes
        Route::apiResource('rate', \App\Http\Controllers\Admin\Website\RateController::class);
        Route::post('rate/section', [\App\Http\Controllers\Admin\Website\RateController::class, 'updateRateSection']);

        // Start section routes
        Route::apiResource('start-section', \App\Http\Controllers\Admin\Website\StartSectionController::class)->only('index', 'store');

        // Footer routes
        Route::apiResource('footer', \App\Http\Controllers\Admin\Website\FooterController::class)->only('index', 'store');

        // Imprint routes
        Route::apiResource('imprint', \App\Http\Controllers\Admin\Website\ImprintController::class)->only('index', 'store');

        // Contact routes
        Route::apiResource('contact/section', \App\Http\Controllers\Admin\Website\Contact\ContactSectionController::class)->only('index', 'store');

        // About routes
        Route::apiResource('about', \App\Http\Controllers\Admin\Website\AboutController::class)->only('index', 'store');

        // Blog types routes
        Route::apiResource('blog/type', \App\Http\Controllers\Admin\Website\Blog\BlogTypeController::class);
        Route::post('blog/type/order', [\App\Http\Controllers\Admin\Website\Blog\BlogTypeController::class, 'order']);

        // Blog routes
        Route::apiResource('blog', \App\Http\Controllers\Admin\Website\Blog\BlogController::class);
        Route::post('blog/order', [\App\Http\Controllers\Admin\Website\Blog\BlogController::class, 'order']);

        // Home settings routes
        Route::get('setting', [\App\Http\Controllers\Admin\Website\SettingController::class, 'index']);
        Route::post('setting', [\App\Http\Controllers\Admin\Website\SettingController::class, 'update']);
    });
});
