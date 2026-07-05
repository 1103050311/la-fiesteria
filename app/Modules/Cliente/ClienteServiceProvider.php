<?php

declare(strict_types=1);

namespace App\Modules\Cliente;

use App\Models\Cliente;
use App\Modules\Cliente\Controllers\ClienteController;
use App\Modules\Cliente\Controllers\DireccionController;
use App\Modules\Cliente\Observers\ClienteObserver;
use App\Modules\Cliente\Policies\ClientePolicy;
use App\Modules\Cliente\Repositories\ClienteRepository;
use App\Modules\Cliente\Repositories\Interfaces\ClienteRepositoryInterface;
use App\Modules\Cliente\Services\ClienteService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * ServiceProvider del módulo Cliente.
 *
 * Responsabilidades:
 *  1. Registrar el binding Interface → Implementación en el contenedor.
 *  2. Registrar las rutas del módulo en /api/v1/clientes.
 *  3. Registrar el Observer del modelo.
 *  4. Registrar la Policy del modelo.
 */
final class ClienteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Binding: cuando el contenedor resuelva ClienteRepositoryInterface,
        // entregará una instancia de ClienteRepository.
        $this->app->bind(
            ClienteRepositoryInterface::class,
            ClienteRepository::class,
        );

        // El Service se resuelve con inyección de dependencia automática.
        $this->app->bind(ClienteService::class);
    }

    public function boot(): void
    {
        $this->registerRoutes();
        $this->registerObservers();
        $this->registerPolicies();
    }

    private function registerRoutes(): void
    {
        Route::middleware(['api', 'auth:sanctum'])
            ->prefix('api/v1')
            ->name('api.v1.clientes.')
            ->group(function (): void {

                // CRUD principal
                Route::apiResource('clientes', ClienteController::class)
                    ->parameters(['clientes' => 'cliente']);

                // Recursos anidados de solo lectura
                Route::get(
                    'clientes/{cliente}/direcciones',
                    [DireccionController::class, 'index']
                )->name('direcciones.index');
            });
    }

    private function registerObservers(): void
    {
        Cliente::observe(ClienteObserver::class);
    }

    private function registerPolicies(): void
    {
        Gate::policy(Cliente::class, ClientePolicy::class);
    }
}
