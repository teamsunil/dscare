<?php

<<<<<<< HEAD
use App\Http\Middleware\RedirectIfAuthenticatedUser;
=======
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
<<<<<<< HEAD
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'guestUser' => RedirectIfAuthenticatedUser::class,
        ]);
=======
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
