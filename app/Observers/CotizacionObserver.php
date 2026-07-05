<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Cotizacion;

class CotizacionObserver
{
    /**
     * Antes de crear una cotización: asignar folio automático si no tiene uno.
     * Formato: COT-YYYYMMDD-XXXX (ejemplo: COT-20260704-0001)
     */
    public function creating(Cotizacion $cotizacion): void
    {
        if (empty($cotizacion->folio)) {
            $cotizacion->folio = $this->generarFolio();
        }
    }

    /**
     * Generar el siguiente folio correlativo del día.
     */
    private function generarFolio(): string
    {
        $fecha  = now()->format('Ymd');
        $prefijo = "COT-{$fecha}-";

        $ultimo = Cotizacion::withTrashed()
            ->where('folio', 'like', "{$prefijo}%")
            ->orderByDesc('folio')
            ->value('folio');

        $secuencia = 1;

        if ($ultimo !== null) {
            $partes    = explode('-', $ultimo);
            $secuencia = (int) end($partes) + 1;
        }

        return sprintf('%s%04d', $prefijo, $secuencia);
    }
}
