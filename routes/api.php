<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::prefix('admin')->group(function () {
    include 'admin.php';
});
