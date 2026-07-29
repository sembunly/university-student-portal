<?php

use App\Http\Controllers\CommuneController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\VillageController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/student/login');

Route::view('/api/documentation', 'api.documentation')
    ->name('api.documentation');

Route::get('/language/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['km', 'en'], true), 404);

    session(['locale' => $locale]);

    return back();
})->name('language.switch');

Route::middleware('guest')->group(function () {
    Route::get('/student/login', [StudentAuthController::class, 'showLogin'])
        ->name('student.login');
    Route::post('/student/login', [StudentAuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('student.login.attempt');
    Route::get('/student/register', [StudentAuthController::class, 'showRegister'])
        ->name('student.register');
    Route::post('/student/register', [StudentAuthController::class, 'register'])
        ->middleware('throttle:5,1')
        ->name('student.register.store');
});

Route::post('/logout', [StudentAuthController::class, 'logout'])
    ->middleware('student.auth')
    ->name('student.logout');

Route::middleware('student.auth')->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
        ->name('student.dashboard');

    Route::get('/student/curriculum', [StudentDashboardController::class, 'curriculum'])
        ->name('student.curriculum');

    Route::get('/student/information/edit', [StudentRegistrationController::class, 'edit'])
        ->name('student.information.edit');

    Route::get('/student/information', [StudentRegistrationController::class, 'show'])
        ->name('student.information.show');

    Route::put('/student/information', [StudentRegistrationController::class, 'update'])
        ->name('student.information.update');

    Route::get('/address/provinces', [ProvinceController::class, 'index'])
        ->name('address.provinces');
    Route::get('/address/provinces/{province}/districts', [DistrictController::class, 'index'])
        ->name('address.districts');
    Route::get('/address/districts/{district}/communes', [CommuneController::class, 'index'])
        ->name('address.communes');
    Route::get('/address/communes/{commune}/villages', [VillageController::class, 'index'])
        ->name('address.villages');
});
