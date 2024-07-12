<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogSessionActivities
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            Log::info('User ' . Auth::user()->id . ' is active.', ['user_id' => Auth::user()->id]);
        }

        return $next($request);
    }
}