<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\VideoUploadController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Public routes
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Payment routes
Route::get('/checkout/{course}', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout/{course}/process', [OrderController::class, 'processPayment'])->name('checkout.process');
Route::get('/payment/success', [OrderController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [OrderController::class, 'cancel'])->name('payment.cancel');

// Protected routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
});

// Admin routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    
    // Admin course management routes
    Route::get('/courses', [AdminController::class, 'courses'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
    
    // Admin lesson management routes
    Route::get('/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
    
    // Video upload routes
    Route::post('/lessons/{lesson}/upload-video', [VideoUploadController::class, 'upload'])->name('lessons.upload-video');
    Route::post('/lessons/{lesson}/upload-thumbnail', [VideoUploadController::class, 'uploadThumbnail'])->name('lessons.upload-thumbnail');
    Route::delete('/lessons/{lesson}/delete-video', [VideoUploadController::class, 'deleteVideo'])->name('lessons.delete-video');
    Route::delete('/lessons/{lesson}/delete-thumbnail', [VideoUploadController::class, 'deleteThumbnail'])->name('lessons.delete-thumbnail');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
