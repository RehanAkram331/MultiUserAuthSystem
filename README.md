
# MultiUserAuth System
## Overview
MultiUserAuth System is a comprehensive web application designed for educational institutions to manage multiple user roles (admin, teacher, student) with robust authentication and management features. It includes two-factor authentication, user profile management, activity logging, and CRUD operations for classes and courses.

## Features
- Multi-User Authentication
 - Roles: Admin, Teacher, Student
Two-Factor Authentication (2FA)
User Management
CRUD operations
Profile management
Activity logging
Course and Class Management
CRUD operations for courses and classes
Enrollment management
Dashboard
Overview of classes, teachers, and courses
Technologies Used
Framework: Laravel 8
Authentication: Laravel's built-in authentication, Two-Factor Authentication (2FA) using Google2FA
Database: MySQL
Frontend: Blade templates, Bootstrap
Activity Logging: Spatie Laravel Activitylog
Installation
Clone the repository:

sh
Copy code
git clone https://github.com/your-repo/MultiUserAuth.git
cd MultiUserAuth
Install dependencies:

sh
Copy code
composer install
npm install
npm run dev
Set up the environment:

Copy .env.example to .env and update the necessary environment variables, including database credentials and mail configuration.
sh
Copy code
cp .env.example .env
Generate application key:

sh
Copy code
php artisan key:generate
Run migrations and seeders:

sh
Copy code
php artisan migrate --seed
Serve the application:

sh
Copy code
php artisan serve
Usage
Access the application via the browser at http://localhost:8000.
Login using the default admin credentials provided by the seeder.
Navigate through the dashboard to manage users, courses, and classes.
Routes
php
Copy code
Route::middleware(['auth:web', '2fa'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/admin/profile/edit', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
    Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::post('/admin/course-enrollments/active/{id}', [CourseEnrollController::class, 'active'])->name('course-enrollments.active');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/user/store', [AdminController::class, 'userStore'])->name('user.store');
    Route::delete('/users/{type}/{id}', [AdminController::class, 'destroy'])->name('user.destroy');
    Route::get('/users/{type}/{id}/edit', [AdminController::class, 'edit'])->name('user.edit');
    Route::post('/users/{id}/update', [AdminController::class, 'update'])->name('user.update');
    Route::get('/student', [StudentController::class, 'index'])->name('student');
    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher');
    Route::resource('courses', CourseController::class);
});
AuthService.php Example
php
Copy code
namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function getAuthenticatedUser()
    {
        return Auth::user();
    }

    public function attemptLogin($request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return Auth::user();
        }
        return null;
    }

    public function redirectTo($user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->is_teacher) {
            return redirect()->route('teacher.dashboard');
        } else {
            return redirect()->route('student.dashboard');
        }
    }
}
Testing
Run the test suite:
sh
Copy code
php artisan test
Contribution
Fork the repository.
Create a new branch (feature/your-feature).
Commit your changes.
Push to the branch.
Create a new Pull Request.
License
This project is licensed under the MIT License.
