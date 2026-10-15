<?php

use App\Http\Middleware\CheckResourceOwnership;
use App\Http\Middleware\SessionCheck;
use App\Http\Middleware\GuestCheck;
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
        $middleware->alias([
            'sessionCheck' => SessionCheck::class,
            'guestCheck' => GuestCheck::class,
            'ownerCheck' => CheckResourceOwnership::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
