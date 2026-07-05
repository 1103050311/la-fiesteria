<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoMovimiento extends Model
{
    use HasFactory;

    protected $table = 'tipos_movimiento';

    /** @var int Entrada de equipo al almacén (compra, devolución) */
    public const ENTRADA       = 1;

    /** @var int Salida de equipo del almacén (renta, préstamo) */
    public const SALIDA        = 2;

    /** @var int Reserva para renta futura */
    public const RESERVA       = 3;

    /** @var int Devolución de equipo por parte del cliente */
    public const DEVOLUCION    = 4;

    /** @var int Envío a mantenimiento */
    public const MANTENIMIENTO = 5;

    /** @var int Ajuste de inventario por auditoría */
    public const AJUSTE        = 6;

    /** @var int Baja definitiva del equipo */
    public const BAJA          = 7;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    /**
     * Movimientos de inventario de este tipo.
     *
     * @return HasMany<MovimientoInventario>
     */
    public function movimientos(): HasMany
    {
        return $this->hasMany(MovimientoInventario::class, 'tipo_movimiento_id');
    }
}
