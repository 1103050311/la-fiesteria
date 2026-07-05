<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\SetTeamUrlDefaults;
use App\Modules\Shared\Exceptions\BusinessException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
            SetTeamUrlDefaults::class,
        ]);

        // Alias para Sanctum en rutas API
        $middleware->alias([
            'abilities'   => \Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
            'ability'     => \Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Todas las rutas api/* siempre devuelven JSON
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // BusinessException y subclases → JSON estructurado
        $exceptions->render(function (BusinessException $e, Request $request): ?\Illuminate\Http\JsonResponse {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'errors'  => null,
                ], $e->getCode());
            }

            return null;
        });

        // ValidationException → JSON estructurado (ya lo hace Laravel, pero lo hacemos explícito)
        $exceptions->render(function (ValidationException $e, Request $request): ?\Illuminate\Http\JsonResponse {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Los datos proporcionados no son válidos.',
                    'errors'  => $e->errors(),
                ], 422);
            }

            return null;
        });

        // Modelo no encontrado → 404 JSON
        $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, Request $request): ?\Illuminate\Http\JsonResponse {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El recurso solicitado no existe.',
                    'errors'  => null,
                ], 404);
            }

            return null;
        });

        // Acceso no autorizado → 403 JSON
        $exceptions->render(function (\Illuminate\Auth\Access\AuthorizationException $e, Request $request): ?\Illuminate\Http\JsonResponse {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permisos para realizar esta acción.',
                    'errors'  => null,
                ], 403);
            }

            return null;
        });

        // No autenticado → 401 JSON
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, Request $request): ?\Illuminate\Http\JsonResponse {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No autenticado. Por favor inicia sesión.',
                    'errors'  => null,
                ], 401);
            }

            return null;
        });
    })->create();

