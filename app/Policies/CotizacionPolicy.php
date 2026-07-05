<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Cotizacion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CotizacionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false; // TODO: implementar con Spatie Permission
    }

    public function view(User $user, Cotizacion $cotizacion): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Cotizacion $cotizacion): bool
    {
        return false;
    }

    public function delete(User $user, Cotizacion $cotizacion): bool
    {
        return false;
    }

    public function restore(User $user, Cotizacion $cotizacion): bool
    {
        return false;
    }

    public function forceDelete(User $user, Cotizacion $cotizacion): bool
    {
        return false;
    }

    /**
     * ¿El usuario puede convertir esta cotización en renta?
     */
    public function convertir(User $user, Cotizacion $cotizacion): bool
    {
        return false; // TODO: implementar con Spatie Permission
    }
}
