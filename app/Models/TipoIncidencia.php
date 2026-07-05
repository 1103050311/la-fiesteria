<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoIncidencia extends Model
{
    use HasFactory;

    protected $table = 'tipos_incidencia';

    /** @var int Equipo con daño físico */
    public const DANIO   = 1;

    /** @var int Equipo reportado como perdido */
    public const PERDIDA = 2;

    /** @var int Retraso en la devolución */
    public const RETRASO = 3;

    /** @var int Equipo robado */
    public const ROBO    = 4;

    /** @var int Otro tipo de incidencia */
    public const OTRO    = 5;

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
     * Incidencias de este tipo.
     *
     * @return HasMany<Incidencia>
     */
    public function incidencias(): HasMany
    {
        return $this->hasMany(Incidencia::class, 'tipo_incidencia_id');
    }
}
