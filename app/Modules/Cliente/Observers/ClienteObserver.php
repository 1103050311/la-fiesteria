<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Observers;

use App\Models\Cliente;
use Illuminate\Support\Facades\Log;

/**
 * Observer del módulo Cliente.
 *
 * Registra en log los eventos del ciclo de vida del cliente.
 * Para lógica más compleja (emails, notificaciones), usar Listeners de Events.
 */
final class ClienteObserver
{
    public function created(Cliente $cliente): void
    {
        Log::info('Cliente creado.', [
            'id'    => $cliente->id,
            'email' => $cliente->email,
        ]);
    }

    public function updated(Cliente $cliente): void
    {
        Log::info('Cliente actualizado.', [
            'id'      => $cliente->id,
            'changes' => $cliente->getChanges(),
        ]);
    }

    public function deleted(Cliente $cliente): void
    {
        Log::warning('Cliente eliminado (soft-delete).', [
            'id'    => $cliente->id,
            'email' => $cliente->email,
        ]);
    }

    public function restored(Cliente $cliente): void
    {
        Log::info('Cliente restaurado.', [
            'id' => $cliente->id,
        ]);
    }
}
