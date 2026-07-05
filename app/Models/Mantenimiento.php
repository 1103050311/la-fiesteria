<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $table = 'mantenimientos';

    protected $fillable = [
        'inventario_id',
        'tipo_mantenimiento_id',
        'fecha',
        'descripcion',
        'costo',
        'proximo_mantenimiento',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha'                 => 'date',
            'costo'                 => 'decimal:2',
            'proximo_mantenimiento' => 'date',
            'created_at'            => 'datetime',
            'updated_at'            => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    /**
     * Unidad física que recibió el mantenimiento.
     *
     * @return BelongsTo<Inventario, Mantenimiento>
     */
    public function inventario(): BelongsTo
    {
        return $this->belongsTo(Inventario::class, 'inventario_id');
    }

    /**
     * Tipo de mantenimiento realizado.
     *
     * @return BelongsTo<TipoMantenimiento, Mantenimiento>
     */
    public function tipoMantenimiento(): BelongsTo
    {
        return $this->belongsTo(TipoMantenimiento::class, 'tipo_mantenimiento_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Mantenimientos programados en los próximos N días.
     *
     * @param  Builder<Mantenimiento>  $query
     * @param  int                     $dias
     * @return Builder<Mantenimiento>
     */
    public function scopeProximos(Builder $query, int $dias = 30): Builder
    {
        return $query->whereBetween('proximo_mantenimiento', [
            now()->toDateString(),
            now()->addDays($dias)->toDateString(),
        ]);
    }

    /**
     * Mantenimientos vencidos (fecha proximo_mantenimiento ya pasó).
     *
     * @param  Builder<Mantenimiento>  $query
     * @return Builder<Mantenimiento>
     */
    public function scopeVencidos(Builder $query): Builder
    {
        return $query->whereNotNull('proximo_mantenimiento')
            ->where('proximo_mantenimiento', '<', now()->toDateString());
    }
}
