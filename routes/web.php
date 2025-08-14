<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LmsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Home route - LMS Dashboard
Route::get('/', [LmsController::class, 'index'])->name('home');

// Public routes
Route::resource('courses', CourseController::class)->only(['index', 'show']);

// Protected routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return redirect('/');
    })->name('dashboard');
    
    // Course management (teachers and admins only)
    Route::resource('courses', CourseController::class)->except(['index', 'show']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
