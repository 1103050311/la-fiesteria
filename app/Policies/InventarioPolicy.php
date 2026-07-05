<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Inventario;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InventarioPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false; // TODO: implementar con Spatie Permission
    }

    public function view(User $user, Inventario $inventario): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Inventario $inventario): bool
    {
        return false;
    }

    public function delete(User $user, Inventario $inventario): bool
    {
        return false;
    }

    public function restore(User $user, Inventario $inventario): bool
    {
        return false;
    }

    public function forceDelete(User $user, Inventario $inventario): bool
    {
        return false;
    }
}
