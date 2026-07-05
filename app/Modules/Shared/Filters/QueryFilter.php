<?php

declare(strict_types=1);

namespace App\Modules\Shared\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Query Object base para filtros de Eloquent.
 *
 * Permite encadenar filtros de forma limpia sin condicionales dispersos
 * en los repositorios. Cada módulo crea su propia subclase:
 *
 *   class ClienteQueryFilter extends QueryFilter {
 *       public function nombre(string $value): void {
 *           $this->builder->where('nombre', 'like', "%{$value}%");
 *       }
 *   }
 *
 * El repositorio lo aplica así:
 *   $filter->apply($query, $request);
 */
abstract class QueryFilter
{
    protected Builder $builder;

    public function __construct(
        protected readonly Request $request,
    ) {}

    /**
     * Aplicar todos los filtros presentes en el request al Builder.
     *
     * @param  Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @return Builder<\Illuminate\Database\Eloquent\Model>
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters() as $filter => $value) {
            if (method_exists($this, $filter) && $value !== null && $value !== '') {
                $this->{$filter}($value);
            }
        }

        return $this->builder;
    }

    /**
     * Retorna los filtros presentes en el request como array clave-valor.
     *
     * @return array<string, mixed>
     */
    protected function filters(): array
    {
        return $this->request->only($this->allowedFilters());
    }

    /**
     * Lista de claves permitidas para filtrar.
     * Cada subclase debe definir qué parámetros del request acepta.
     *
     * @return array<string>
     */
    abstract protected function allowedFilters(): array;
}
