<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Repositories\Interfaces;

use App\Models\Cliente;
use App\Modules\Cliente\Filters\ClienteQueryFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Contrato del repositorio de Clientes.
 *
 * El Service depende de esta interfaz, nunca de la implementación concreta.
 * Esto permite testear el Service con un mock sin tocar la base de datos.
 */
interface ClienteRepositoryInterface
{
    /**
     * Obtener listado paginado con filtros aplicados.
     *
     * @param  array<string>  $relations
     */
    public function paginateWithFilter(
        ClienteQueryFilter $filter,
        array $relations = [],
        int $perPage = 15,
    ): LengthAwarePaginator;

    /**
     * Buscar por ID, retorna null si no existe.
     *
     * @param  array<string>  $relations
     */
    public function findClienteById(int $id, array $relations = []): ?Cliente;

    /**
     * Buscar por ID o lanzar ClienteNotFoundException.
     *
     * @param  array<string>  $relations
     *
     * @throws \App\Modules\Cliente\Exceptions\ClienteNotFoundException
     */
    public function findClienteOrFail(int $id, array $relations = []): Cliente;

    /**
     * Crear un nuevo cliente.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): \Illuminate\Database\Eloquent\Model;

    /**
     * Actualizar un cliente existente.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(\Illuminate\Database\Eloquent\Model $model, array $data): \Illuminate\Database\Eloquent\Model;

    /**
     * Soft-delete de un cliente.
     */
    public function delete(\Illuminate\Database\Eloquent\Model $model): bool;
}
