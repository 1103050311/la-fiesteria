<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Compra;
use App\Models\Cotizacion;
use App\Models\Evento;
use App\Models\Cliente;
use App\Models\Inventario;
use App\Models\MovimientoInventario;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Renta;
use App\Observers\CotizacionObserver;
use App\Observers\MovimientoInventarioObserver;
use App\Observers\RentaObserver;
use App\Policies\ClientePolicy;
use App\Policies\CompraPolicy;
use App\Policies\CotizacionPolicy;
use App\Policies\EventoPolicy;
use App\Policies\InventarioPolicy;
use App\Policies\PagoPolicy;
use App\Policies\ProductoPolicy;
use App\Policies\RentaPolicy;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->registerObservers();
        $this->registerPolicies();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    /**
     * Registrar observers del sistema.
     */
    protected function registerObservers(): void
    {
        Cotizacion::observe(CotizacionObserver::class);
        Renta::observe(RentaObserver::class);
        MovimientoInventario::observe(MovimientoInventarioObserver::class);
    }

    /**
     * Registrar el mapa de políticas de autorización.
     */
    protected function registerPolicies(): void
    {
        Gate::policy(Cliente::class,    ClientePolicy::class);
        Gate::policy(Evento::class,     EventoPolicy::class);
        Gate::policy(Cotizacion::class, CotizacionPolicy::class);
        Gate::policy(Renta::class,      RentaPolicy::class);
        Gate::policy(Inventario::class, InventarioPolicy::class);
        Gate::policy(Producto::class,   ProductoPolicy::class);
        Gate::policy(Pago::class,       PagoPolicy::class);
        Gate::policy(Compra::class,     CompraPolicy::class);
    }
}
