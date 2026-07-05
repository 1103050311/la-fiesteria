<?php

declare(strict_types=1);

namespace App\Modules\Auth\Controllers;

use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Resources\AuthResource;
use App\Modules\Auth\Resources\UserProfileResource;
use App\Modules\Auth\Services\AuthService;
use App\Modules\Shared\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

final class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private readonly AuthService $authService,
    ) {}

    /**
     * POST /api/v1/auth/login
     *
     * Iniciar sesión y obtener un Bearer Token.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $payload = $this->authService->login(
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString(),
        );

        return $this->success(
            data: new AuthResource($payload),
            message: 'Sesión iniciada correctamente.',
        );
    }

    /**
     * POST /api/v1/auth/logout
     *
     * Revocar el token actual. Requiere auth:sanctum.
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return $this->noContent('Sesión cerrada correctamente.');
    }

    /**
     * GET /api/v1/auth/me
     *
     * Retornar el perfil del usuario autenticado con sus roles y permisos.
     */
    public function me(Request $request): JsonResponse
    {
        return $this->success(
            data: new UserProfileResource($request->user()),
            message: 'Perfil obtenido correctamente.',
        );
    }
}
