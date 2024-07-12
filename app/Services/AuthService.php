<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;

class AuthService
{
    public function attemptLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = null;

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
        } elseif (Auth::guard('student')->attempt($credentials)) {
            $user = Auth::guard('student')->user();
        } elseif (Auth::guard('teacher')->attempt($credentials)) {
            $user = Auth::guard('teacher')->user();
        }

        if ($user) {
            $request->session()->regenerate();
            $request->session()->put('role', $this->getUserRole($user));

            return $user;
        }
        return false;
    }

    public function getAuthenticatedUser()
    {
        if (Auth::guard('web')->check()) {
            return Auth::guard('web')->user();
        } elseif (Auth::guard('student')->check()) {
            return Auth::guard('student')->user();
        } elseif (Auth::guard('teacher')->check()) {
            return Auth::guard('teacher')->user();
        }

        return Auth::user();
    }

    public function redirectTo($user)
    {
        if ($user instanceof User) {
            return '/admin/dashboard';
        } elseif ($user instanceof Student) {
            return '/student/dashboard';
        } elseif ($user instanceof Teacher) {
            return '/teacher/dashboard';
        }
    }

    protected function getUserRole($user)
    {
        if ($user instanceof User) {
            return 'admin';
        } elseif ($user instanceof Student) {
            return 'student';
        } elseif ($user instanceof Teacher) {
            return 'teacher';
        }
    }

}