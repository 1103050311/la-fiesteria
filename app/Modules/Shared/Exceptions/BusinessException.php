<?php

declare(strict_types=1);

namespace App\Modules\Shared\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Excepción base para errores de lógica de negocio.
 * Lanzar esta excepción (o subclases) en lugar de abort().
 *
 * El ExceptionHandler la captura y devuelve HTTP 422 con el mensaje dado.
 */
class BusinessException extends Exception
{
    public function __construct(
        string $message = 'Ha ocurrido un error en la operación.',
        int $code = Response::HTTP_UNPROCESSABLE_ENTITY,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
