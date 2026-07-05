<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entrega extends Model
{
    use HasFactory;

    protected $table = 'entregas';

    protected $fillable = [
        'renta_id',
        'user_id',
        'fecha',
        'persona_recibe',
        'observaciones',
        'firma',
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
     * Renta a la que corresponde esta entrega.
     *
     * @return BelongsTo<Renta, Entrega>
     */
    public function renta(): BelongsTo
    {
        return $this->belongsTo(Renta::class, 'renta_id');
    }

    /**
     * Usuario (empleado) que realizó la entrega.
     *
     * @return BelongsTo<User, Entrega>
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
