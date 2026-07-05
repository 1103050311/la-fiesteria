<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direcciones';

    protected $fillable = [
        'cliente_id',
        'calle',
        'numero',
        'colonia',
        'ciudad',
        'estado',
        'codigo_postal',
        'referencia',
        'principal',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'principal'  => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    /**
     * Dirección formateada en una sola línea.
     */
    public function getDireccionCompletaAttribute(): string
    {
        return "{$this->calle} {$this->numero}, {$this->colonia}, {$this->ciudad}, {$this->estado} C.P. {$this->codigo_postal}";
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    /**
     * Cliente al que pertenece esta dirección.
     *
     * @return BelongsTo<Cliente, Direccion>
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
