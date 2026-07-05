<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Renta extends Model
{
    use HasFactory;
    // Sin SoftDeletes — las rentas NUNCA se eliminan por integridad financiera

    protected $table = 'rentas';

    protected $fillable = [
        'cliente_id',
        'evento_id',
        'cotizacion_id',
        'usuario_id',
        'estado_renta_id',
        'folio',
        'fecha_renta',
        'fecha_entrega',
        'fecha_devolucion',
        'subtotal',
        'descuento',
        'iva',
        'total',
        'notas_internas',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_renta'      => 'date',
            'fecha_entrega'    => 'date',
            'fecha_devolucion' => 'date',
            'subtotal'         => 'decimal:2',
            'descuento'        => 'decimal:2',
            'iva'              => 'decimal:2',
            'total'            => 'decimal:2',
            'created_at'       => 'datetime',
            'updated_at'       => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    /**
     * Cliente que realiza la renta.
     *
     * @return BelongsTo<Cliente, Renta>
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Evento al que corresponde la renta (opcional).
     *
     * @return BelongsTo<Evento, Renta>
     */
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    /**
     * Cotización de origen (si la renta surgió de una cotización previa).
     *
     * @return BelongsTo<Cotizacion, Renta>
     */
    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id');
    }

    /**
     * Usuario que registró la renta.
     *
     * @return BelongsTo<User, Renta>
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Estado actual de la renta.
     *
     * @return BelongsTo<EstadoRenta, Renta>
     */
    public function estadoRenta(): BelongsTo
    {
        return $this->belongsTo(EstadoRenta::class, 'estado_renta_id');
    }

    /**
     * Renglones de detalle de la renta.
     *
     * @return HasMany<DetalleRenta>
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleRenta::class, 'renta_id');
    }

    /**
     * Pagos realizados para esta renta.
     *
     * @return HasMany<Pago>
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'renta_id');
    }

    /**
     * Registros de entrega del equipo.
     *
     * @return HasMany<Entrega>
     */
    public function entregas(): HasMany
    {
        return $this->hasMany(Entrega::class, 'renta_id');
    }

    /**
     * Registros de devolución del equipo.
     *
     * @return HasMany<Devolucion>
     */
    public function devoluciones(): HasMany
    {
        return $this->hasMany(Devolucion::class, 'renta_id');
    }

    /**
     * Incidencias registradas durante esta renta.
     *
     * @return HasMany<Incidencia>
     */
    public function incidencias(): HasMany
    {
        return $this->hasMany(Incidencia::class, 'renta_id');
    }

    /**
     * Movimientos de inventario asociados a esta renta.
     *
     * @return HasMany<MovimientoInventario>
     */
    public function movimientos(): HasMany
    {
        return $this->hasMany(MovimientoInventario::class, 'renta_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Rentas activas (en preparación o ya entregadas).
     *
     * @param  Builder<Renta>  $query
     * @return Builder<Renta>
     */
    public function scopeActivas(Builder $query): Builder
    {
        return $query->whereIn('estado_renta_id', [
            EstadoRenta::PREPARACION,
            EstadoRenta::ENTREGADA,
        ]);
    }

    /**
     * Rentas con fecha de entrega en una fecha específica.
     *
     * @param  Builder<Renta>  $query
     * @param  string          $fecha  Formato Y-m-d
     * @return Builder<Renta>
     */
    public function scopeEntregaEn(Builder $query, string $fecha): Builder
    {
        return $query->whereDate('fecha_entrega', $fecha);
    }

    /**
     * Rentas entregadas que aún no han sido devueltas.
     *
     * @param  Builder<Renta>  $query
     * @return Builder<Renta>
     */
    public function scopePendienteDevolucion(Builder $query): Builder
    {
        return $query->where('estado_renta_id', EstadoRenta::ENTREGADA)
            ->whereNull('fecha_devolucion');
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Total pagado hasta el momento.
     */
    public function totalPagado(): float
    {
        return (float) $this->pagos->sum('monto');
    }

    /**
     * Saldo pendiente de pago.
     */
    public function saldoPendiente(): float
    {
        return (float) $this->total - $this->totalPagado();
    }

    /**
     * ¿La renta está completamente pagada?
     */
    public function estaPagada(): bool
    {
        return $this->saldoPendiente() <= 0;
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
