<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false; // TODO: implementar con Spatie Permission
    }

    public function view(User $user, Cliente $cliente): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Cliente $cliente): bool
    {
        return false;
    }

    public function delete(User $user, Cliente $cliente): bool
    {
        return false;
    }

    public function restore(User $user, Cliente $cliente): bool
    {
        return false;
    }

    public function forceDelete(User $user, Cliente $cliente): bool
    {
        return false;
    }
}
