<?php

declare(strict_types=1);

namespace App\Modules\Auth\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Perfil del usuario autenticado (para GET /auth/me).
 *
 * @mixin User
 */
class UserProfileResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $this */
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'roles'       => $this->getRoleNames(),
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'created_at'  => $this->created_at?->toIso8601String(),
        ];
    }
}
