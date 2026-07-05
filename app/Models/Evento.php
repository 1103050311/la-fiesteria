<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'eventos';

    protected $fillable = [
        'cliente_id',
        'tipo_evento_id',
        'nombre',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'direccion',
        'invitados',
        'observaciones',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha'      => 'date',
            'invitados'  => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    /**
     * Cliente titular del evento.
     *
     * @return BelongsTo<Cliente, Evento>
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Tipo de evento (boda, quinceañera, corporativo, etc.).
     *
     * @return BelongsTo<TipoEvento, Evento>
     */
    public function tipoEvento(): BelongsTo
    {
        return $this->belongsTo(TipoEvento::class, 'tipo_evento_id');
    }

    /**
     * Cotizaciones relacionadas con este evento.
     *
     * @return HasMany<Cotizacion>
     */
    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class, 'evento_id');
    }

    /**
     * Rentas relacionadas con este evento.
     *
     * @return HasMany<Renta>
     */
    public function rentas(): HasMany
    {
        return $this->hasMany(Renta::class, 'evento_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Solo eventos con fecha igual o posterior a hoy.
     *
     * @param  Builder<Evento>  $query
     * @return Builder<Evento>
     */
    public function scopeFuturos(Builder $query): Builder
    {
        return $query->where('fecha', '>=', now()->toDateString());
    }

    /**
     * Eventos dentro de un rango de fechas.
     *
     * @param  Builder<Evento>  $query
     * @param  string           $desde
     * @param  string           $hasta
     * @return Builder<Evento>
     */
    public function scopeEntreFechas(Builder $query, string $desde, string $hasta): Builder
    {
        return $query->whereBetween('fecha', [$desde, $hasta]);
    }
}
