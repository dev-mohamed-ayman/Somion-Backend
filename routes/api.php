<?php

use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::prefix('admin')->middleware([HandleCors::class])->group(function () {
    include 'admin.php';
});
