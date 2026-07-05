<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Policies;

use App\Models\Cliente;
use App\Models\User;
use App\Modules\Cliente\Enums\ClientePermission;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Policy del módulo Cliente basada en permisos de Spatie.
 *
 * Los permisos se definen en ClientePermission y se asignan
 * a roles vía el Seeder de permisos.
 */
final class ClientePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(ClientePermission::VIEW_ANY->value);
    }

    public function view(User $user, Cliente $cliente): bool
    {
        return $user->hasPermissionTo(ClientePermission::VIEW->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(ClientePermission::CREATE->value);
    }

    public function update(User $user, Cliente $cliente): bool
    {
        return $user->hasPermissionTo(ClientePermission::UPDATE->value);
    }

    public function delete(User $user, Cliente $cliente): bool
    {
        return $user->hasPermissionTo(ClientePermission::DELETE->value);
    }

    public function restore(User $user, Cliente $cliente): bool
    {
        return $user->hasPermissionTo(ClientePermission::RESTORE->value);
    }

    /**
     * Los super admins bypasean todas las políticas.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        return null;
    }
}
