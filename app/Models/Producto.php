<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'codigo',
        'nombre',
        'descripcion',
        'precio_renta',
        'precio_reposicion',
        'requiere_mantenimiento',
        'activo',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'precio_renta'           => 'decimal:2',
            'precio_reposicion'      => 'decimal:2',
            'requiere_mantenimiento' => 'boolean',
            'activo'                 => 'boolean',
            'created_at'             => 'datetime',
            'updated_at'             => 'datetime',
            'deleted_at'             => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    /**
     * Categoría del producto.
     *
     * @return BelongsTo<Categoria, Producto>
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Unidades físicas del inventario de este producto.
     *
     * @return HasMany<Inventario>
     */
    public function inventarios(): HasMany
    {
        return $this->hasMany(Inventario::class, 'producto_id');
    }

    /**
     * Renglones de cotizaciones que incluyen este producto.
     *
     * @return HasMany<DetalleCotizacion>
     */
    public function detalleCotizaciones(): HasMany
    {
        return $this->hasMany(DetalleCotizacion::class, 'producto_id');
    }

    /**
     * Renglones de rentas que incluyen este producto.
     *
     * @return HasMany<DetalleRenta>
     */
    public function detalleRentas(): HasMany
    {
        return $this->hasMany(DetalleRenta::class, 'producto_id');
    }

    /**
     * Renglones de compras de este producto.
     *
     * @return HasMany<DetalleCompra>
     */
    public function detalleCompras(): HasMany
    {
        return $this->hasMany(DetalleCompra::class, 'producto_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Solo productos activos en el catálogo.
     *
     * @param  Builder<Producto>  $query
     * @return Builder<Producto>
     */
    public function scopeActivos(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    /**
     * Solo productos que requieren mantenimiento periódico.
     *
     * @param  Builder<Producto>  $query
     * @return Builder<Producto>
     */
    public function scopeRequiereMantenimiento(Builder $query): Builder
    {
        return $query->where('requiere_mantenimiento', true);
    }

    /**
     * Buscar productos por nombre, código o descripción.
     *
     * @param  Builder<Producto>  $query
     * @param  string             $termino
     * @return Builder<Producto>
     */
    public function scopeBuscar(Builder $query, string $termino): Builder
    {
        return $query->where(function (Builder $q) use ($termino): void {
            $q->where('nombre', 'like', "%{$termino}%")
                ->orWhere('codigo', 'like', "%{$termino}%")
                ->orWhere('descripcion', 'like', "%{$termino}%");
        });
    }
}
