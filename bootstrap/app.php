<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            //global middleware apply in all route
            \App\Http\Middleware\LogSessionActivities::class,            
        ]);
        $middleware->alias([
            '2fa' => \App\Http\Middleware\Google2FAMiddleware::class,
            'auth.multiple' => \App\Http\Middleware\AuthenticateMultipleGuards::class,
        ]);
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
