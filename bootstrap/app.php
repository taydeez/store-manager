<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

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
        $middleware->validateCsrfTokens(except: [
            'http://localhost:3000'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (\Exception $e, $request) {

            //Spatie unauthorized (user has no permission)
            if ($e instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
                return response()->json([
                    'message' => 'Unauthorized.',
                    'error' => $e->getMessage(),
                ], 403);
            }

            //Authentication failure (invalid or missing token)
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                return response()->json([
                    'message' => 'Unauthenticated.',
                    'error' => $e->getMessage(),
                ], 401);
            }

            //Validation errors
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json([
                    'message' => 'Validation failed.',
                    'errors' => $e->errors(),
                ], 422);
            }

            //Model not found (e.g. User::findOrFail)
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->json([
                    'message' => 'Resource not found.',
                    'error' => $e->getMessage(),
                ], 404);
            }

            //Route not found (invalid URL)
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return response()->json([
                    'message' => 'Endpoint not found.',
                    'error' => $e->getMessage(),
                ], 404);
            }

            //Default fallback
            return response()->json([
                'message' => 'Server error.',
                'error' => config('app.debug') ? $e->getMessage() : 'Something went wrong',
            ], 500);


        });

    })->create();

