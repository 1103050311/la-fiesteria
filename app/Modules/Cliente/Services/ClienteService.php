<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Services;

use App\Models\Cliente;
use App\Modules\Cliente\DTOs\StoreClienteDTO;
use App\Modules\Cliente\DTOs\UpdateClienteDTO;
use App\Modules\Cliente\Events\ClienteCreated;
use App\Modules\Cliente\Events\ClienteDeleted;
use App\Modules\Cliente\Events\ClienteUpdated;
use App\Modules\Cliente\Filters\ClienteQueryFilter;
use App\Modules\Cliente\Repositories\Interfaces\ClienteRepositoryInterface;
use App\Modules\Shared\Exceptions\BusinessException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Capa de orquestación del módulo Cliente.
 *
 * Coordina entre el Repository, los Events y cualquier otra dependencia.
 * No contiene consultas Eloquent directas; todo pasa por el Repository.
 */
final class ClienteService
{
    public function __construct(
        private readonly ClienteRepositoryInterface $repository,
    ) {}

    /**
     * Obtener listado paginado de clientes con filtros.
     *
     * @param  array<string>  $relations
     */
    public function index(
        ClienteQueryFilter $filter,
        array $relations = ['direccionPrincipal'],
        int $perPage = 15,
    ): LengthAwarePaginator {
        return $this->repository->paginateWithFilter($filter, $relations, $perPage);
    }

    /**
     * Obtener un cliente por ID con sus relaciones.
     *
     * @param  array<string>  $relations
     *
     * @throws \App\Modules\Cliente\Exceptions\ClienteNotFoundException
     */
    public function show(
        int $id,
        array $relations = ['direcciones'],
    ): Cliente {
        return $this->repository->findClienteOrFail($id, $relations);
    }

    /**
     * Crear un nuevo cliente desde un DTO validado.
     */
    public function store(StoreClienteDTO $dto): Cliente
    {
        /** @var Cliente $cliente */
        $cliente = $this->repository->create($dto->toArray());

        event(new ClienteCreated($cliente));

        return $cliente;
    }

    /**
     * Actualizar un cliente existente.
     *
     * @throws \App\Modules\Cliente\Exceptions\ClienteNotFoundException
     */
    public function update(int $id, UpdateClienteDTO $dto): Cliente
    {
        $cliente = $this->repository->findClienteOrFail($id);

        /** @var Cliente $updated */
        $updated = $this->repository->update($cliente, $dto->toArray());

        event(new ClienteUpdated($updated));

        return $updated;
    }

    /**
     * Eliminar (soft-delete) un cliente.
     *
     * Regla de negocio: no se puede eliminar un cliente con rentas activas.
     *
     * @throws \App\Modules\Cliente\Exceptions\ClienteNotFoundException
     * @throws BusinessException
     */
    public function destroy(int $id): void
    {
        $cliente = $this->repository->findClienteOrFail($id, ['rentas']);

        // Verificar que no tenga rentas en estado no terminal
        $rentasActivas = $cliente->rentas()
            ->whereNotIn('estado_renta_id', [
                \App\Models\EstadoRenta::FINALIZADA,
                \App\Models\EstadoRenta::CANCELADA,
            ])->exists();

        if ($rentasActivas) {
            throw new BusinessException(
                'No es posible eliminar un cliente con rentas activas.'
            );
        }

        $this->repository->delete($cliente);

        event(new ClienteDeleted($cliente));
    }
}
