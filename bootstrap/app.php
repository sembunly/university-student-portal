<?php

use App\Http\Middleware\EnsureStudentAuthenticated;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Railway terminates HTTPS at its reverse proxy. Trust the forwarded
        // protocol/host so Laravel generates secure asset and redirect URLs.
        $middleware->trustProxies(at: '*');

        $middleware->appendToGroup('web', SetLocale::class);
        $middleware->alias([
            'student.auth' => EnsureStudentAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
