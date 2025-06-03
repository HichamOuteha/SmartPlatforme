<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AIController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Public course routes
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Authentication routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Course lessons for all authenticated users
    Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');

    // Student routes
    Route::middleware(['auth', 'role:student'])->group(function () {
        Route::get('/student/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');
        
        // Enrollments
        Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('enrollments.store');
        Route::get('/my-courses', [EnrollmentController::class, 'index'])->name('enrollments.index');
        Route::get('/my-courses/{course}', [EnrollmentController::class, 'show'])->name('enrollments.show');
        Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('courses.enroll');
        Route::delete('/courses/{course}/unenroll', [EnrollmentController::class, 'unenroll'])->name('courses.unenroll');
        Route::get('/my-courses', [EnrollmentController::class, 'myCourses'])->name('enrollments.my-courses');
        Route::get('/courses/{course}/progress', [EnrollmentController::class, 'showProgress'])->name('enrollments.progress');
        
        // Lessons
        Route::post('/lessons/{lesson}/complete', [LessonController::class, 'complete'])->name('student.lessons.complete');
        
        // Payments
        Route::get('/courses/{course}/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
        Route::get('/courses/{course}/payment/success', [PaymentController::class, 'success'])->name('payment.success');
        Route::get('/courses/{course}/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
        
        // Ratings
        Route::post('/courses/{course}/rate', [RatingController::class, 'store'])->name('courses.rate');
        Route::put('/courses/{course}/rate', [RatingController::class, 'update'])->name('courses.rate.update');
        Route::delete('/courses/{course}/rate', [RatingController::class, 'destroy'])->name('courses.rate.destroy');
    });

    // Teacher routes
    Route::middleware(['auth', 'role:teacher'])->group(function () {
        Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
        
        // Course management
        Route::get('/teacher/courses/create', [CourseController::class, 'create'])->name('teacher.courses.create');
        Route::post('/teacher/courses', [CourseController::class, 'store'])->name('teacher.courses.store');
        Route::get('/teacher/courses/{course}/edit', [CourseController::class, 'edit'])->name('teacher.courses.edit');
        Route::put('/teacher/courses/{course}', [CourseController::class, 'update'])->name('teacher.courses.update');
        Route::delete('/teacher/courses/{course}', [CourseController::class, 'destroy'])->name('teacher.courses.destroy');
        Route::post('/teacher/courses/{course}/publish', [CourseController::class, 'togglePublish'])->name('teacher.courses.publish');
        
        // Lesson management
        Route::get('/teacher/courses/{course}/lessons', [LessonController::class, 'index'])->name('teacher.lessons.index');
        Route::get('/teacher/courses/{course}/lessons/create', [LessonController::class, 'create'])->name('teacher.lessons.create');
        Route::post('/teacher/courses/{course}/lessons', [LessonController::class, 'store'])->name('teacher.lessons.store');
        Route::get('/teacher/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('teacher.lessons.edit');
        Route::put('/teacher/lessons/{lesson}', [LessonController::class, 'update'])->name('teacher.lessons.update');
        Route::delete('/teacher/lessons/{lesson}', [LessonController::class, 'destroy'])->name('teacher.lessons.destroy');
        Route::post('/teacher/courses/{course}/lessons/reorder', [LessonController::class, 'reorder'])->name('teacher.lessons.reorder');
    });

    // Admin routes
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
    });

    // Certificate routes
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::middleware('role:student')->group(function () {
        Route::get('/courses/{course}/certificate/generate', [CertificateController::class, 'generate'])->name('certificates.generate');
    });
    Route::get('/certificates/{certificate}', [CertificateController::class, 'show'])->name('certificates.show');
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');
});

// Public certificate verification
Route::get('/certificates/verify/{number}', [CertificateController::class, 'verify'])->name('certificates.verify');

// Stripe webhook
Route::post('/webhook/stripe', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Chat routes
Route::middleware(['web'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])
        ->name('chat.send')
        ->middleware('auth');
});




