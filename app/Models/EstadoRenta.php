<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoRenta extends Model
{
    use HasFactory;

    protected $table = 'estados_renta';

    /** @var int Renta generada desde cotización, aún no confirmada */
    public const COTIZADA    = 1;

    /** @var int Renta confirmada por el cliente */
    public const CONFIRMADA  = 2;

    /** @var int Equipo en preparación para entrega */
    public const PREPARACION = 3;

    /** @var int Equipo entregado al cliente */
    public const ENTREGADA   = 4;

    /** @var int Equipo devuelto a almacén */
    public const DEVUELTA    = 5;

    /** @var int Renta completada y cerrada */
    public const FINALIZADA  = 6;

    /** @var int Renta cancelada */
    public const CANCELADA   = 7;

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
     * Rentas con este estado.
     *
     * @return HasMany<Renta>
     */
    public function rentas(): HasMany
    {
        return $this->hasMany(Renta::class, 'estado_renta_id');
    }
}
