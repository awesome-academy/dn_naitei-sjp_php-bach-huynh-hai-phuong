<?php

use App\Http\Middleware\EnsureRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\RouteNotFoundException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => EnsureRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                return match (true) {
                    $e instanceof AuthenticationException => response()->json([
                        'success' => false,
                        'message' => __('response.unauthorized'),
                    ], Response::HTTP_UNAUTHORIZED),

                    $e instanceof ValidationException => response()->json([
                        'success' => false,
                        'message' => __('response.validation_failed'),
                        'errors' => $e->errors(),
                    ], Response::HTTP_UNPROCESSABLE_ENTITY),

                    $e instanceof NotFoundHttpException => response()->json([
                        'success' => false,
                        'message' => __('response.resource_not_found'),
                    ], Response::HTTP_NOT_FOUND),

                    $e instanceof HttpException => response()->json([
                        'success' => false,
                        'message' => $e->getMessage(),
                    ], $e->getStatusCode()),

                    $e instanceof RouteNotFoundException => response()->json([
                        'success' => false,
                        'message' => __('response.route_not_found'),
                    ], Response::HTTP_NOT_FOUND),

                    default => response()->json([
                        'success' => false,
                        'message' => __('response.unexpected_error'),
                        'details' => $e->getMessage(),
                    ], Response::HTTP_INTERNAL_SERVER_ERROR),
                };
            }
        });
    })->create();
