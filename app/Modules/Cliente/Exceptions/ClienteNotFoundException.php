<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Exceptions;

use App\Modules\Shared\Exceptions\ResourceNotFoundException;

/**
 * Se lanza cuando el cliente solicitado no existe en la base de datos.
 */
final class ClienteNotFoundException extends ResourceNotFoundException
{
    public function __construct(
        string $message = 'El cliente solicitado no existe.',
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, 404, $previous);
    }
}
