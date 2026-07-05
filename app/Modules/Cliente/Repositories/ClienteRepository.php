<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Repositories;

use App\Models\Cliente;
use App\Modules\Cliente\Exceptions\ClienteNotFoundException;
use App\Modules\Cliente\Filters\ClienteQueryFilter;
use App\Modules\Cliente\Repositories\Interfaces\ClienteRepositoryInterface;
use App\Modules\Shared\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * Implementación Eloquent del repositorio de Clientes.
 *
 * Solo interactúa con el modelo Cliente.
 * No contiene lógica de negocio; eso es responsabilidad del Service.
 */
final class ClienteRepository extends BaseRepository implements ClienteRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Cliente());
    }

    /**
     * Obtener listado paginado con filtros aplicados.
     *
     * @param  array<string>  $relations
     */
    public function paginateWithFilter(
        ClienteQueryFilter $filter,
        array $relations = ['direccionPrincipal'],
        int $perPage = 15,
    ): LengthAwarePaginator {
        $query = $this->query()->with($relations);

        return $filter->apply($query)
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Buscar cliente por ID, retorna null si no existe.
     *
     * @param  array<string>  $relations
     */
    public function findClienteById(int $id, array $relations = []): ?Cliente
    {
        /** @var Cliente|null */
        return $this->query()
            ->with($relations)
            ->find($id);
    }

    /**
     * Buscar cliente por ID o lanzar ClienteNotFoundException.
     *
     * @param  array<string>  $relations
     *
     * @throws ClienteNotFoundException
     */
    public function findClienteOrFail(int $id, array $relations = []): Cliente
    {
        $cliente = $this->findClienteById($id, $relations);

        if ($cliente === null) {
            throw new ClienteNotFoundException();
        }

        return $cliente;
    }
}
