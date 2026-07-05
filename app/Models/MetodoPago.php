<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MetodoPago extends Model
{
    use HasFactory;

    protected $table = 'metodos_pago';

    /** @var int Transferencia bancaria o SPEI */
    public const TRANSFERENCIA = 1;

    /** @var int Pago en efectivo */
    public const EFECTIVO      = 2;

    /** @var int Tarjeta de crédito o débito */
    public const TARJETA       = 3;

    /** @var int Cheque */
    public const CHEQUE        = 4;

    /** @var int Otro método de pago */
    public const OTRO          = 5;

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
     * Pagos realizados con este método.
     *
     * @return HasMany<Pago>
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'metodo_pago_id');
    }
}
