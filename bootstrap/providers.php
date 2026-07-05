<?php

use App\Modules\Auth\AuthServiceProvider;
use App\Modules\Cliente\ClienteServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider;

return [
    // ── Core ─────────────────────────────────────────────────────────────
    AppServiceProvider::class,
    FortifyServiceProvider::class,

    // ── Módulos API ───────────────────────────────────────────────────────
    AuthServiceProvider::class,
    ClienteServiceProvider::class,
    // ProductoServiceProvider::class,
    // InventarioServiceProvider::class,
    // EventoServiceProvider::class,
    // CotizacionServiceProvider::class,
    // RentaServiceProvider::class,
    // PagoServiceProvider::class,
    // ProveedorServiceProvider::class,
    // CompraServiceProvider::class,
    // DashboardServiceProvider::class,
];
