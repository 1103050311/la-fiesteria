<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoInventario extends Model
{
    use HasFactory;

    protected $table = 'estados_inventario';

    /** @var int Estado: unidad disponible en almacén */
    public const DISPONIBLE     = 1;

    /** @var int Estado: unidad actualmente rentada */
    public const RENTADO        = 2;

    /** @var int Estado: unidad reservada para una renta futura */
    public const RESERVADO      = 3;

    /** @var int Estado: unidad en proceso de mantenimiento */
    public const MANTENIMIENTO  = 4;

    /** @var int Estado: unidad con daños */
    public const DANADO         = 5;

    /** @var int Estado: unidad reportada como perdida */
    public const PERDIDO        = 6;

    /** @var int Estado: unidad dada de baja / fuera de servicio */
    public const FUERA_SERVICIO = 7;

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
     * Unidades del inventario con este estado.
     *
     * @return HasMany<Inventario>
     */
    public function inventarios(): HasMany
    {
        return $this->hasMany(Inventario::class, 'estado_inventario_id');
    }
}
