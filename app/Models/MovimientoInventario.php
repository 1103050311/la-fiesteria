<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoInventario extends Model
{
    use HasFactory;

    protected $table = 'movimientos_inventario';

    protected $fillable = [
        'inventario_id',
        'tipo_movimiento_id',
        'renta_id',
        'user_id',
        'fecha',
        'observaciones',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha'      => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    /**
     * Unidad física que registra el movimiento.
     *
     * @return BelongsTo<Inventario, MovimientoInventario>
     */
    public function inventario(): BelongsTo
    {
        return $this->belongsTo(Inventario::class, 'inventario_id');
    }

    /**
     * Tipo de movimiento realizado.
     *
     * @return BelongsTo<TipoMovimiento, MovimientoInventario>
     */
    public function tipoMovimiento(): BelongsTo
    {
        return $this->belongsTo(TipoMovimiento::class, 'tipo_movimiento_id');
    }

    /**
     * Renta asociada al movimiento (si aplica).
     *
     * @return BelongsTo<Renta, MovimientoInventario>
     */
    public function renta(): BelongsTo
    {
        return $this->belongsTo(Renta::class, 'renta_id');
    }

    /**
     * Usuario que registró el movimiento.
     *
     * @return BelongsTo<User, MovimientoInventario>
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Movimientos en un rango de fechas.
     *
     * @param  Builder<MovimientoInventario>  $query
     * @param  string                         $desde  Formato Y-m-d
     * @param  string                         $hasta  Formato Y-m-d
     * @return Builder<MovimientoInventario>
     */
    public function scopeEntreFechas(Builder $query, string $desde, string $hasta): Builder
    {
        return $query->whereBetween('fecha', [$desde, $hasta]);
    }
}
