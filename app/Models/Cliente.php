<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'email',
        'rfc',
        'observaciones',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    /**
     * Nombre completo del cliente (nombre + ambos apellidos).
     */
    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}");
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    /**
     * Todas las direcciones del cliente.
     *
     * @return HasMany<Direccion>
     */
    public function direcciones(): HasMany
    {
        return $this->hasMany(Direccion::class, 'cliente_id');
    }

    /**
     * Dirección principal del cliente.
     *
     * @return HasMany<Direccion>
     */
    public function direccionPrincipal(): HasMany
    {
        return $this->hasMany(Direccion::class, 'cliente_id')
            ->where('principal', true);
    }

    /**
     * Eventos del cliente.
     *
     * @return HasMany<Evento>
     */
    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class, 'cliente_id');
    }

    /**
     * Cotizaciones del cliente.
     *
     * @return HasMany<Cotizacion>
     */
    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class, 'cliente_id');
    }

    /**
     * Rentas del cliente.
     *
     * @return HasMany<Renta>
     */
    public function rentas(): HasMany
    {
        return $this->hasMany(Renta::class, 'cliente_id');
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    /**
     * Buscar clientes por nombre, apellidos, email, teléfono o RFC.
     *
     * @param  Builder<Cliente>  $query
     * @param  string            $termino
     * @return Builder<Cliente>
     */
    public function scopeBuscar(Builder $query, string $termino): Builder
    {
        return $query->where(function (Builder $q) use ($termino): void {
            $q->where('nombre', 'like', "%{$termino}%")
                ->orWhere('apellido_paterno', 'like', "%{$termino}%")
                ->orWhere('apellido_materno', 'like', "%{$termino}%")
                ->orWhere('email', 'like', "%{$termino}%")
                ->orWhere('telefono', 'like', "%{$termino}%")
                ->orWhere('rfc', 'like', "%{$termino}%");
        });
    }
}
