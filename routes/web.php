<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\TeacherProfileController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CourseEnrollController;


Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});


Route::middleware(['auth:web','2fa'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/course-enrollments/active/{id}', [CourseEnrollController::class, 'active'])->name('course-enrollments.avtive');

});

Route::middleware(['auth:web','2fa'])->prefix('user')->name('user.')->group(function () {
    Route::post('/store', [AdminController::class, 'userStore'])->name('store'); 
    Route::delete('/{type}/{id}', [AdminController::class, 'destroy'])->name('destroy');
    Route::get('/{type}/{id}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::post('/{id}/update', [AdminController::class, 'update'])->name('update');

});

Route::middleware(['auth:web','2fa'])->group(function () {
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::get('/student', [StudentController::class, 'index'])->name('student');
    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher');    
    Route::resource('courses', CourseController::class);
});

Route::middleware(['auth:teacher','2fa'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [TeacherController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [TeacherController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [TeacherController::class, 'updateProfile'])->name('profile.update');
});


Route::middleware(['auth:student','2fa'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [StudentController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
    Route::get('/classes', [ClassController::class, 'index'])->name('classes');
});

Route::middleware('auth.multiple:web,teacher,student')->group(function () {
    Route::get('/', [AuthController::class, 'home'])->name('home');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('2fa/enable', [TwoFactorController::class, 'enableTwoFactor'])->name('2fa.enable');
    Route::post('2fa/disable', [TwoFactorController::class, 'disableTwoFactor'])->name('2fa.disable');
    Route::get('2fa/verify', [AuthController::class, 'show2FAVerifyForm'])->name('2fa.verify');
    Route::post('2fa/verify', [AuthController::class, 'verify2FA']);
    Route::post('/check', )->name('user.check');
});

Route::middleware(['auth.multiple:web,student','2fa'])->group(function () {
    Route::resource('course-enrollments', CourseEnrollController::class);
});

Route::middleware(['auth.multiple:web,teacher','2fa'])->group(function () {
    Route::resource('classes', ClassController::class);      
});



