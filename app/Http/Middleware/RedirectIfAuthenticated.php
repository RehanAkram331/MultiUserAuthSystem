<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('web')->check()) {
            return redirect('/admin/dashboard');
        } elseif (Auth::guard('student')->check()) {
            return redirect('/student/dashboard');
        } elseif (Auth::guard('teacher')->check()) {
            return redirect('/teacher/dashboard');
        }

        return $next($request);
    }
}