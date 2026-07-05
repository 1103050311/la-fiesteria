<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Renta;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RentaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false; // TODO: implementar con Spatie Permission
    }

    public function view(User $user, Renta $renta): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Renta $renta): bool
    {
        return false;
    }

    /**
     * Las rentas nunca se eliminan — política siempre denegada.
     */
    public function delete(User $user, Renta $renta): bool
    {
        return false;
    }

    /**
     * ¿El usuario puede cancelar esta renta?
     */
    public function cancelar(User $user, Renta $renta): bool
    {
        return false; // TODO: implementar con Spatie Permission
    }

    /**
     * ¿El usuario puede registrar entrega de esta renta?
     */
    public function registrarEntrega(User $user, Renta $renta): bool
    {
        return false; // TODO: implementar con Spatie Permission
    }
}
