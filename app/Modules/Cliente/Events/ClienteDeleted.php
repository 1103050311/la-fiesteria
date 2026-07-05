<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Events;

use App\Models\Cliente;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class ClienteDeleted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Cliente $cliente,
    ) {}
}
