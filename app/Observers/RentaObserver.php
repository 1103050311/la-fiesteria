<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Renta;

class RentaObserver
{
    /**
     * Antes de crear una renta: asignar folio automático si no tiene uno.
     * Formato: RNT-YYYYMMDD-XXXX (ejemplo: RNT-20260704-0001)
     */
    public function creating(Renta $renta): void
    {
        if (empty($renta->folio)) {
            $renta->folio = $this->generarFolio();
        }
    }

    /**
     * Generar el siguiente folio correlativo del día.
     */
    private function generarFolio(): string
    {
        $fecha   = now()->format('Ymd');
        $prefijo = "RNT-{$fecha}-";

        $ultimo = Renta::where('folio', 'like', "{$prefijo}%")
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
