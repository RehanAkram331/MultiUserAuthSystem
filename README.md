
# MultiUserAuth System
## Overview
MultiUserAuth System is a comprehensive web application designed for educational institutions to manage multiple user roles (admin, teacher, student) with robust authentication and management features. It includes two-factor authentication, user profile management, activity logging, and CRUD operations for classes and courses.

## Features
- Multi-User Authentication
    - Roles: Admin, Teacher, Student
    - Two-Factor Authentication (2FA)
- User Management
    - CRUD operations
    - Profile management
    - Activity logging
- Course and Class Management
    - CRUD operations for courses and classes
    - Enrollment management
- Dashboard
    - Overview of classes, teachers, and courses
      
## Technologies Used
- Framework: Laravel 11
- Authentication: Laravel's built-in authentication, Two-Factor Authentication (2FA) using Google2FA
- Database: MySQL
- Frontend: Blade templates, Bootstrap
- Activity Logging: Spatie Laravel Activitylog
  
## Installation
- Clone the repository:
    - git clone https://github.com/RehanAkram331/MultiUserAuthSystem.git
    - cd MultiUserAuthSystem

### Install dependencies:
     composer install
     npm install
     npm run dev
    
### Set up the environment: Copy .env.example to .env and update the necessary environment variables, including database credentials and mail configuration.
    cp .env.example .env
    
### Generate application key:
    php artisan key:generate

### Run migrations and seeders:
    php artisan migrate --seed
    
### Serve the application:
    php artisan serve
    
## Usage
- Access the application via the browser at http://localhost:8000.
- Login using the default admin credentials:
    - Email: admin@example.com
    - Password: Admin@1234

- Navigate through the dashboard to manage users, courses, and classes.
### Routes:
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

    
### AuthService.php Example

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
