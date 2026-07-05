<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Compra;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompraPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false; // TODO: implementar con Spatie Permission
    }

    public function view(User $user, Compra $compra): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Compra $compra): bool
    {
        return false;
    }

    public function delete(User $user, Compra $compra): bool
    {
        return false;
    }

    public function restore(User $user, Compra $compra): bool
    {
        return false;
    }

    public function forceDelete(User $user, Compra $compra): bool
    {
        return false;
    }
}
