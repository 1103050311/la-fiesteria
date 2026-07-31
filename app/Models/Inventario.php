<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inventarios';

    protected $fillable = [
        'producto_id',
        'estado_inventario_id',
        'piezasDisponibles',
        'piezasTotales',
        'numero_serie',
        'codigo_interno',
        'ubicacion',
        'fecha_compra',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_compra' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    /**
     * Producto al que pertenece esta unidad física.
     *
     * @return BelongsTo<Producto, Inventario>
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    /**
     * Estado actual de la unidad.
     *
     * @return BelongsTo<EstadoInventario, Inventario>
     */
    public function estadoInventario(): BelongsTo
    {
        return $this->belongsTo(EstadoInventario::class, 'estado_inventario_id');
    }

    /**
     * Incidencias registradas para esta unidad.
     *
     * @return HasMany<Incidencia>
     */
    public function incidencias(): HasMany
    {
        return $this->hasMany(Incidencia::class, 'inventario_id');
    }

    /**
     * Mantenimientos registrados para esta unidad.
     *
     * @return HasMany<Mantenimiento>
     */
    public function mantenimientos(): HasMany
    {
        return $this->hasMany(Mantenimiento::class, 'inventario_id');
    }

    /**
     * Historial completo de movimientos de esta unidad.
     *
     * @return HasMany<MovimientoInventario>
     */
    public function movimientos(): HasMany
    {
        return $this->hasMany(MovimientoInventario::class, 'inventario_id');
    }

    /**
     * Rentas en las que se ha asignado esta unidad física.
     *
     * @return HasMany<DetalleRenta>
     */
    public function detalleRentas(): HasMany
    {
        return $this->hasMany(DetalleRenta::class, 'inventario_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Solo unidades disponibles en almacén.
     *
     * @param  Builder<Inventario>  $query
     * @return Builder<Inventario>
     */
    public function scopeDisponibles(Builder $query): Builder
    {
        return $query->where('estado_inventario_id', EstadoInventario::DISPONIBLE);
    }

    /**
     * Solo unidades actualmente rentadas.
     *
     * @param  Builder<Inventario>  $query
     * @return Builder<Inventario>
     */
    public function scopeRentados(Builder $query): Builder
    {
        return $query->where('estado_inventario_id', EstadoInventario::RENTADO);
    }

    /**
     * Solo unidades en mantenimiento.
     *
     * @param  Builder<Inventario>  $query
     * @return Builder<Inventario>
     */
    public function scopeEnMantenimiento(Builder $query): Builder
    {
        return $query->where('estado_inventario_id', EstadoInventario::MANTENIMIENTO);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * ¿La unidad está disponible para rentar?
     */
    public function estaDisponible(): bool
    {
        return $this->estado_inventario_id === EstadoInventario::DISPONIBLE;
    }
}
