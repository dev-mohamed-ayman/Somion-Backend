<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Website routes
Route::get('home', [\App\Http\Controllers\Website\WebsiteController::class, 'index']);

// Admin Routes
Route::prefix('admin')->group(function () {
    include 'admin.php';
});
