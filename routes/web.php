<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Main dashboard - redirect to attendance dashboard
    Route::get('dashboard', [AttendanceController::class, 'index'])->name('dashboard');
    
    // Attendance routes
    Route::controller(AttendanceController::class)->prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
    });
    
    // Students management
    Route::resource('students', StudentController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
