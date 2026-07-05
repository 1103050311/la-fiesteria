<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoMantenimiento extends Model
{
    use HasFactory;

    protected $table = 'tipos_mantenimiento';

    /** @var int Mantenimiento preventivo programado */
    public const PREVENTIVO  = 1;

    /** @var int Mantenimiento correctivo por falla o daño */
    public const CORRECTIVO  = 2;

    /** @var int Limpieza y desinfección del equipo */
    public const LIMPIEZA    = 3;

    /** @var int Calibración o ajuste técnico */
    public const CALIBRACION = 4;

    /** @var int Inspección general del equipo */
    public const INSPECCION  = 5;

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
     * Mantenimientos de este tipo.
     *
     * @return HasMany<Mantenimiento>
     */
    public function mantenimientos(): HasMany
    {
        return $this->hasMany(Mantenimiento::class, 'tipo_mantenimiento_id');
    }
}
