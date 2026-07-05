<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoCotizacion extends Model
{
    use HasFactory;

    protected $table = 'estados_cotizacion';

    /** @var int Cotización creada, sin enviar al cliente */
    public const PENDIENTE = 1;

    /** @var int Cotización enviada al cliente */
    public const ENVIADA   = 2;

    /** @var int Cliente aceptó la cotización */
    public const ACEPTADA  = 3;

    /** @var int Cliente rechazó la cotización */
    public const RECHAZADA = 4;

    /** @var int Cotización vencida por tiempo */
    public const EXPIRADA  = 5;

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
     * Cotizaciones con este estado.
     *
     * @return HasMany<Cotizacion>
     */
    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class, 'estado_cotizacion_id');
    }
}
