<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Google2FAMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->google2fa_secret && !$user->google2fa_enabled) {
            return redirect()->route('2fa.verify');                      
        }
        return $next($request);
    }
}
