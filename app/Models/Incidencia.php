<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incidencia extends Model
{
    use HasFactory;

    protected $table = 'incidencias';

    protected $fillable = [
        'renta_id',
        'inventario_id',
        'tipo_incidencia_id',
        'descripcion',
        'costo',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'costo'      => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    /**
     * Renta en la que ocurrió la incidencia.
     *
     * @return BelongsTo<Renta, Incidencia>
     */
    public function renta(): BelongsTo
    {
        return $this->belongsTo(Renta::class, 'renta_id');
    }

    /**
     * Unidad física afectada por la incidencia.
     *
     * @return BelongsTo<Inventario, Incidencia>
     */
    public function inventario(): BelongsTo
    {
        return $this->belongsTo(Inventario::class, 'inventario_id');
    }

    /**
     * Tipo de incidencia registrada.
     *
     * @return BelongsTo<TipoIncidencia, Incidencia>
     */
    public function tipoIncidencia(): BelongsTo
    {
        return $this->belongsTo(TipoIncidencia::class, 'tipo_incidencia_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Solo incidencias que generaron un costo.
     *
     * @param  Builder<Incidencia>  $query
     * @return Builder<Incidencia>
     */
    public function scopeConCosto(Builder $query): Builder
    {
        return $query->where('costo', '>', 0);
    }
}
