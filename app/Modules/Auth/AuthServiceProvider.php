<?php

declare(strict_types=1);

namespace App\Modules\Auth;

use Illuminate\Support\ServiceProvider;

/**
 * ServiceProvider del módulo Auth.
 *
 * Responsabilidades:
 *  - Registrar las rutas del módulo (montadas en api.php directamente).
 *  - Registrar bindings propios si los hubiera.
 *
 * Las rutas Auth se registran en routes/api.php directamente
 * porque son las primeras en cargarse (sin auth middleware).
 */
class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            \App\Modules\Auth\Services\AuthService::class,
        );
    }

    public function boot(): void
    {
        // Las rutas se definen en routes/api.php para evitar
        // problemas de orden de carga con el middleware auth:sanctum
    }
}
