<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Teams\TeamInvitationController;
use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\SolicitudesController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\WhatsappController;

Route::inertia('/', 'welcome')->name('home');

//Client routes
Route::post('whatsapp/enviar', [WhatsappController::class, 'enviar'])->name('whatsapp.enviar');


//admin routes
Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');
        Route::get('inventario', [InventarioController::class, 'invoke'])->name('inventario');
        Route::get('productos', [ProductosController::class, 'invoke'])->name('productos');
        Route::get('categorias', [CategoriasController::class, 'invoke'])->name('categorias');
        Route::get('solicitudes', [SolicitudesController::class, 'invoke'])->name('solicitudes');
        Route::get('reservas', [ReservasController::class, 'invoke'])->name('reservas');
        Route::get('galeria', [GaleriaController::class, 'invoke'])->name('galeria');
        Route::get('reportes', [ReportesController::class, 'invoke'])->name('reportes');

    });

Route::middleware(['auth'])->group(function () {
    Route::get('invitations/{invitation}/accept', [TeamInvitationController::class, 'accept'])->name('invitations.accept');
    Route::delete('invitations/{invitation}', [TeamInvitationController::class, 'decline'])->name('invitations.decline');
});

require __DIR__ . '/settings.php';
