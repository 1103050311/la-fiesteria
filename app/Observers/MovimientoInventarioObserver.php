<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\MovimientoInventario;
use Illuminate\Support\Facades\Log;

class MovimientoInventarioObserver
{
    /**
     * Después de crear un movimiento: actualizar el estado del inventario.
     *
     * Este observer es el punto central para sincronizar el estado de una
     * unidad del inventario cada vez que se registra un movimiento.
     * La lógica de negocio de transición de estados debe implementarse aquí.
     */
    public function created(MovimientoInventario $movimiento): void
    {
        // TODO: Implementar la lógica de transición de estados según el tipo de movimiento.
        // Ejemplo de implementación futura:
        //
        // match ($movimiento->tipo_movimiento_id) {
        //     TipoMovimiento::SALIDA     => $movimiento->inventario->update(['estado_inventario_id' => EstadoInventario::RENTADO]),
        //     TipoMovimiento::DEVOLUCION => $movimiento->inventario->update(['estado_inventario_id' => EstadoInventario::DISPONIBLE]),
        //     TipoMovimiento::MANTENIMIENTO => $movimiento->inventario->update(['estado_inventario_id' => EstadoInventario::MANTENIMIENTO]),
        //     TipoMovimiento::BAJA       => $movimiento->inventario->update(['estado_inventario_id' => EstadoInventario::FUERA_SERVICIO]),
        //     default => null,
        // };

        Log::info('Movimiento de inventario registrado', [
            'inventario_id'      => $movimiento->inventario_id,
            'tipo_movimiento_id' => $movimiento->tipo_movimiento_id,
            'renta_id'           => $movimiento->renta_id,
            'user_id'            => $movimiento->user_id,
            'fecha'              => $movimiento->fecha,
        ]);
    }

    /**
     * Antes de eliminar: prevenir eliminación de movimientos de inventario.
     * El historial de movimientos es inmutable por integridad del sistema.
     */
    public function deleting(MovimientoInventario $movimiento): bool
    {
        // Retornar false cancela la operación de eliminación
        return false;
    }
}
