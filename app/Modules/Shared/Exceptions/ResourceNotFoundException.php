<?php

declare(strict_types=1);

namespace App\Modules\Shared\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * Excepción para recursos no encontrados (HTTP 404).
 * Cada módulo puede lanzar su propia subclase:
 *   class ClienteNotFoundException extends ResourceNotFoundException { ... }
 */
class ResourceNotFoundException extends BusinessException
{
    public function __construct(
        string $message = 'El recurso solicitado no existe.',
        int $code = Response::HTTP_NOT_FOUND,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
