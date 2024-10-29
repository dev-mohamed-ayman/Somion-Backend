<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Website routes
Route::controller(\App\Http\Controllers\Website\WebsiteController::class)->group(function () {
    Route::get('hero', 'hero');
    Route::get('services', 'services');
    Route::get('projects', 'projects');
    Route::get('brands', 'brands');
    Route::get('whies', 'whies');
    Route::get('rates', 'rates');
    Route::post('rates', 'rate');
    Route::get('start-section', 'startSection');
    Route::get('footer', 'footer');
    Route::post('subscription', 'subscription');
    Route::get('imprint', 'imprint');
    Route::get('contact-section', 'contactSection');
    Route::post('contact', 'contact');
    Route::get('about', 'about');
    Route::get('service-category/{id}', 'serviceCategory');
    Route::get('service/{id}', 'service');
});
// Admin Routes
Route::prefix('admin')->group(function () {
    include 'admin.php';
});
