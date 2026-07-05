<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Devolucion extends Model
{
    use HasFactory;

    protected $table = 'devoluciones';

    protected $fillable = [
        'renta_id',
        'user_id',
        'fecha',
        'observaciones',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha'      => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    /**
     * Renta a la que corresponde esta devolución.
     *
     * @return BelongsTo<Renta, Devolucion>
     */
    public function renta(): BelongsTo
    {
        return $this->belongsTo(Renta::class, 'renta_id');
    }

    /**
     * Usuario (empleado) que registró la devolución.
     *
     * @return BelongsTo<User, Devolucion>
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
