<?php

use App\Http\Middleware\SsoAuthMiddleware;
use App\Http\Middleware\SuperadminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'sso.auth' => SsoAuthMiddleware::class,
            'superadmin' => SuperadminMiddleware::class,
            'admin' => App\Http\Middleware\AdminMiddleware::class,
            'admin.task' => App\Http\Middleware\AdminTaskMiddleware::class,
            'user' => App\Http\Middleware\UserMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
