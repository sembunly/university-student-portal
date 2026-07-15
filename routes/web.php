<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::redirect('/', '/student/login');

Route::get('/language/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['km', 'en'], true), 404);

    session(['locale' => $locale]);

    return back();
})->name('language.switch');

Route::view('/student/login', 'student.login')->name('student.login');

Route::post('/student/login', function (Request $request) {
    $credentials = $request->validate([
        'student_id' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    if ($credentials['student_id'] !== 'demo' || $credentials['password'] !== '1') {
        return back()
            ->withErrors(['student_id' => __('student.login.invalid')])
            ->onlyInput('student_id');
    }

    $request->session()->regenerate();
    $request->session()->put([
        'student_demo_authenticated' => true,
        'student_demo_id' => 'demo',
    ]);

    return to_route('student.dashboard');
})->name('student.login.attempt');

Route::post('/logout', function (Request $request) {
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return to_route('student.login');
})->name('student.logout');

Route::middleware('student.demo.auth')->group(function () {
    Route::view('/student/dashboard', 'student.dashboard')
        ->name('student.dashboard');

    Route::view('/student/information/edit', 'student.update-student-information')
        ->name('student.information.edit');

    Route::view('/student/information', 'student.student-information')
        ->name('student.information.show');

    Route::post('/student/information', function (Request $request) {
        $request->validate([
            'name_km' => ['required', 'string', 'max:100'],
            'name_en' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'in:ប្រុស,ស្រី'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'declaration' => ['accepted'],
        ]);

        return to_route('student.information.edit')
            ->with('success', 'ព័ត៌មាននិស្សិតត្រូវបានផ្ទៀងផ្ទាត់ដោយជោគជ័យ។');
    })->name('student.information.update');
});
