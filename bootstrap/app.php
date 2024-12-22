<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\RedirectDefaultLocaleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Varsayılan web middleware grubuna SetLocale middleware'ini ekle
        $middleware->web()->append(SetLocale::class);
        $middleware->web()->append(RedirectDefaultLocaleMiddleware::class);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
