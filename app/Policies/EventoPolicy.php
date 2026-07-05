<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false; // TODO: implementar con Spatie Permission
    }

    public function view(User $user, Evento $evento): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Evento $evento): bool
    {
        return false;
    }

    public function delete(User $user, Evento $evento): bool
    {
        return false;
    }

    public function restore(User $user, Evento $evento): bool
    {
        return false;
    }

    public function forceDelete(User $user, Evento $evento): bool
    {
        return false;
    }
}
