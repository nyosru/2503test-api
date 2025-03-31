<?php

use App\Http\Controllers\Api\ResourceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api'], function () {
    Route::get('resources', [ResourceController::class, 'index']);
    Route::get('bookings', [\App\Http\Controllers\BookingController::class, 'index']);
});

Route::view('/', 'welcome');

//Route::view('dashboard', 'dashboard')
//    ->middleware(['auth', 'verified'])
//    ->name('dashboard');
//
//Route::view('profile', 'profile')
//    ->middleware(['auth'])
//    ->name('profile');

require __DIR__.'/auth.php';
