<?php

declare(strict_types=1);

namespace App\Modules\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transforma el payload de autenticación.
 *
 * @property \App\Models\User $resource['user']
 * @property string           $resource['token']
 */
class AuthResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var array{user: \App\Models\User, token: string, token_type: string} $this->resource */
        $data = $this->resource;

        return [
            'token'      => $data['token'],
            'token_type' => $data['token_type'],
            'user'       => [
                'id'    => $data['user']->id,
                'name'  => $data['user']->name,
                'email' => $data['user']->email,
                'roles' => $data['user']->getRoleNames(),
            ],
        ];
    }
}
