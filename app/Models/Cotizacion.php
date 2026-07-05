<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cotizacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cotizaciones';

    protected $fillable = [
        'cliente_id',
        'evento_id',
        'usuario_id',
        'estado_cotizacion_id',
        'folio',
        'fecha',
        'subtotal',
        'descuento',
        'iva',
        'total',
        'observaciones',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha'      => 'date',
            'subtotal'   => 'decimal:2',
            'descuento'  => 'decimal:2',
            'iva'        => 'decimal:2',
            'total'      => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    /**
     * Cliente al que pertenece la cotización.
     *
     * @return BelongsTo<Cliente, Cotizacion>
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Evento asociado a la cotización (opcional).
     *
     * @return BelongsTo<Evento, Cotizacion>
     */
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    /**
     * Usuario que generó la cotización.
     *
     * @return BelongsTo<User, Cotizacion>
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Estado actual de la cotización.
     *
     * @return BelongsTo<EstadoCotizacion, Cotizacion>
     */
    public function estadoCotizacion(): BelongsTo
    {
        return $this->belongsTo(EstadoCotizacion::class, 'estado_cotizacion_id');
    }

    /**
     * Renglones de detalle de la cotización.
     *
     * @return HasMany<DetalleCotizacion>
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleCotizacion::class, 'cotizacion_id');
    }

    /**
     * Renta generada desde esta cotización (si fue aceptada y convertida).
     *
     * @return HasOne<Renta>
     */
    public function renta(): HasOne
    {
        return $this->hasOne(Renta::class, 'cotizacion_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Cotizaciones en estado Pendiente.
     *
     * @param  Builder<Cotizacion>  $query
     * @return Builder<Cotizacion>
     */
    public function scopePendientes(Builder $query): Builder
    {
        return $query->where('estado_cotizacion_id', EstadoCotizacion::PENDIENTE);
    }

    /**
     * Cotizaciones aceptadas por el cliente.
     *
     * @param  Builder<Cotizacion>  $query
     * @return Builder<Cotizacion>
     */
    public function scopeAceptadas(Builder $query): Builder
    {
        return $query->where('estado_cotizacion_id', EstadoCotizacion::ACEPTADA);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * ¿La cotización puede convertirse en renta?
     * Debe estar aceptada y no tener ya una renta asociada.
     */
    public function puedeConvertirse(): bool
    {
        return $this->estado_cotizacion_id === EstadoCotizacion::ACEPTADA
            && $this->renta === null;
    }

    /**
     * Recalcular y asignar los totales según los detalles actuales.
     *
     * @param  float  $porcentajeIva  Porcentaje de IVA (default 16%)
     * @param  float  $descuento      Monto de descuento a aplicar
     */
    public function calcularTotales(float $porcentajeIva = 16.0, float $descuento = 0.0): void
    {
        $subtotal        = (float) $this->detalles->sum('subtotal');
        $this->subtotal  = $subtotal;
        $this->descuento = $descuento;
        $this->iva       = ($subtotal - $descuento) * ($porcentajeIva / 100);
        $this->total     = ($subtotal - $descuento) + $this->iva;
    }
}
