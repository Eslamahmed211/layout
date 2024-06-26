<?php

use App\Http\Middleware\isAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\checkrole;
use App\Http\Middleware\isUser;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            Route::middleware(['web'])
                ->group(base_path('routes/web.php'));

            Route::middleware(['web', 'auth', "isAdmin"])
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware(['web', 'auth', "isUser"])
                ->prefix('users')
                ->group(base_path('routes/users.php'));
        },
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(["isAdmin" => isAdmin::class, "checkRole" =>  checkrole::class, "isUser" => isUser::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
