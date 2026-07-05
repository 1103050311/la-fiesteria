<?php

declare(strict_types=1);

namespace App\Modules\Auth\Exceptions;

use App\Modules\Shared\Exceptions\BusinessException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Credenciales inválidas durante el intento de login.
 */
class InvalidCredentialsException extends BusinessException
{
    public function __construct(
        string $message = 'Las credenciales proporcionadas son incorrectas.',
        int $code = Response::HTTP_UNAUTHORIZED,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
