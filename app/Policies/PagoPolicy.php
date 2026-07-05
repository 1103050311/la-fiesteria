<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Pago;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false; // TODO: implementar con Spatie Permission
    }

    public function view(User $user, Pago $pago): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Pago $pago): bool
    {
        return false;
    }

    public function delete(User $user, Pago $pago): bool
    {
        return false;
    }
}
