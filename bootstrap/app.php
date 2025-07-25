<?php

use Illuminate\Auth\AuthenticationException;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('api')->group(base_path('routes/api.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middlewares\ForceJsonResponse::class);
        $middleware->append(\App\Http\Middlewares\ClientAuthMiddleware::class);
        $middleware->alias([
            'client.auth' => \App\Http\Middlewares\ClientAuthMiddleware::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'ForceJson' => \App\Http\Middlewares\ForceJsonResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

                $exceptions->render(function (UnauthorizedException $e, $request) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'message' => 'Unauthorized.'
                        ], 401);
                    }
                    return redirect()->guest(route('login'));
                });

    })->create();

