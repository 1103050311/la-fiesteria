<?php

declare(strict_types=1);

use App\Modules\Auth\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — La Fiesteria v1
|--------------------------------------------------------------------------
| Todas las rutas de negocio están prefijadas con /api/v1
| y agrupadas por módulo en sus respectivos ServiceProviders.
|
| Aquí solo se registran las rutas de Auth (sin auth:sanctum).
| El resto lo registra cada ModuleServiceProvider.
|
*/

Route::prefix('v1')->name('api.v1.')->group(function (): void {

    // ── Auth (público) ──────────────────────────────────────────────────
    Route::prefix('auth')->name('auth.')->group(function (): void {
        Route::post('login', [AuthController::class, 'login'])->name('login');
    });

    // ── Auth (requiere token) ────────────────────────────────────────────
    Route::middleware('auth:sanctum')->prefix('auth')->name('auth.')->group(function (): void {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('me', [AuthController::class, 'me'])->name('me');
    });

    // ── Módulos de negocio (cargados por sus ServiceProviders) ───────────
    // Las rutas de cada módulo se registran automáticamente vía:
    // ClienteServiceProvider, ProductoServiceProvider, etc.
});
