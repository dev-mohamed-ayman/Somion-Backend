<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Admin Routes
Route::prefix('admin')->middleware()->group(function () {
    include 'admin.php';
});
