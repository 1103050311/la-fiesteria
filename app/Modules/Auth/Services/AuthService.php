<?php

declare(strict_types=1);

namespace App\Modules\Auth\Services;

use App\Models\User;
use App\Modules\Auth\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\Hash;

final class AuthService
{
    /**
     * Autenticar un usuario con email y password.
     * Retorna el usuario + Bearer token generado por Sanctum.
     *
     * @return array{user: User, token: string, token_type: string}
     *
     * @throws InvalidCredentialsException si las credenciales no son válidas
     */
    public function login(string $email, string $password): array
    {
        $user = User::query()
            ->where('email', $email)
            ->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw new InvalidCredentialsException();
        }

        // Revocar tokens anteriores para evitar acumulación (opcional: mantener si se necesita multi-device)
        // $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'user'       => $user,
            'token'      => $token,
            'token_type' => 'Bearer',
        ];
    }

    /**
     * Revocar el token actual del usuario autenticado.
     */
    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
