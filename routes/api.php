<?php

use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::prefix('admin')->middleware(['auth:sanctum', 'lang', 'cors', 'json'])->group(function () {
    include 'admin.php';
});
