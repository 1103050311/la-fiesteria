<?php

declare(strict_types=1);

namespace App\Modules\Shared\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Repositorio base genérico.
 *
 * Implementa las operaciones CRUD comunes usando Eloquent.
 * Cada módulo hereda de esta clase y sobreescribe lo que necesita.
 *
 * @template TModel of Model
 */
abstract class BaseRepository
{
    /**
     * @param  TModel  $model
     */
    public function __construct(
        protected readonly Model $model,
    ) {}

    /**
     * Obtener todos los registros (sin paginación).
     *
     * @param  array<string>  $relations
     * @return Collection<int, TModel>
     */
    public function all(array $relations = []): Collection
    {
        return $this->model->newQuery()
            ->with($relations)
            ->get();
    }

    /**
     * Obtener colección paginada.
     *
     * @param  array<string>  $relations
     * @param  int            $perPage
     */
    public function paginate(
        array $relations = [],
        int $perPage = 15,
    ): LengthAwarePaginator {
        return $this->model->newQuery()
            ->with($relations)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Buscar por ID. Retorna null si no existe.
     *
     * @param  array<string>  $relations
     * @return TModel|null
     */
    public function findById(int $id, array $relations = []): ?Model
    {
        return $this->model->newQuery()
            ->with($relations)
            ->find($id);
    }

    /**
     * Buscar por ID o lanzar ModelNotFoundException.
     *
     * @param  array<string>  $relations
     * @return TModel
     */
    public function findOrFail(int $id, array $relations = []): Model
    {
        return $this->model->newQuery()
            ->with($relations)
            ->findOrFail($id);
    }

    /**
     * Crear un nuevo registro.
     *
     * @param  array<string, mixed>  $data
     * @return TModel
     */
    public function create(array $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    /**
     * Actualizar un registro existente.
     *
     * @param  TModel                $model
     * @param  array<string, mixed>  $data
     * @return TModel
     */
    public function update(Model $model, array $data): Model
    {
        $model->update($data);

        return $model->fresh();
    }

    /**
     * Eliminar un registro (soft delete si el modelo lo soporta).
     *
     * @param  TModel  $model
     */
    public function delete(Model $model): bool
    {
        return (bool) $model->delete();
    }

    /**
     * Restaurar un registro soft-deleted.
     *
     * @param  TModel  $model
     */
    public function restore(Model $model): bool
    {
        if (! in_array(SoftDeletes::class, class_uses_recursive($model))) {
            return false;
        }

        return (bool) $model->restore();
    }

    /**
     * Exponer el query builder base para operaciones personalizadas en subclases.
     *
     * @return Builder<TModel>
     */
    protected function query(): Builder
    {
        return $this->model->newQuery();
    }
}
