<?php

use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\StudentDashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function (): void {
    Route::get('/health', fn () => response()->json([
        'data' => ['status' => 'ok', 'version' => 'v1'],
    ]))->name('health');

    Route::middleware('throttle:5,1')->group(function (): void {
        Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
    });

    Route::middleware('api.token')->group(function (): void {
        Route::get('/auth/me', [AuthController::class, 'me'])->name('auth.me');
        Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::match(['put', 'post'], '/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::get('/addresses/provinces', [AddressController::class, 'provinces'])
            ->name('addresses.provinces');
        Route::get('/addresses/provinces/{province}/districts', [AddressController::class, 'districts'])
            ->name('addresses.districts');
        Route::get('/addresses/districts/{district}/communes', [AddressController::class, 'communes'])
            ->name('addresses.communes');
        Route::get('/addresses/communes/{commune}/villages', [AddressController::class, 'villages'])
            ->name('addresses.villages');
    });

    Route::middleware('student.auth')->group(function (): void {
        Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
            ->name('student.dashboard');
        Route::get('/student/curriculum', [StudentDashboardController::class, 'curriculum'])
            ->name('student.curriculum');
    });
});
