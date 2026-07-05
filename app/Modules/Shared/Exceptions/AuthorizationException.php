<?php

declare(strict_types=1);

namespace App\Modules\Shared\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * Excepción para operaciones no autorizadas dentro de la lógica de negocio.
 * Diferente de 401 (no autenticado): este es 403 (autenticado pero sin permiso).
 */
class AuthorizationException extends BusinessException
{
    public function __construct(
        string $message = 'No tienes permisos para realizar esta operación.',
        int $code = Response::HTTP_FORBIDDEN,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
