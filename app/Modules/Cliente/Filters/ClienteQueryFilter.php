<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Filters;

use App\Modules\Shared\Filters\QueryFilter;

/**
 * Filtros disponibles para el listado de Clientes.
 *
 * Cada método público es invocado automáticamente por QueryFilter::apply()
 * cuando el parámetro está presente en el request.
 *
 * Parámetros soportados:
 *   ?nombre=Juan         → busca en nombre y apellido_paterno
 *   ?email=juan@...      → busca email exacto
 *   ?rfc=JUAM...         → busca RFC exacto
 *   ?telefono=55...      → busca en teléfono
 *   ?buscar=texto        → búsqueda global en todos los campos
 */
class ClienteQueryFilter extends QueryFilter
{
    /**
     * @return array<string>
     */
    protected function allowedFilters(): array
    {
        return ['nombre', 'email', 'rfc', 'telefono', 'buscar'];
    }

    /**
     * Filtro por nombre o apellido paterno.
     */
    public function nombre(string $value): void
    {
        $like = "%{$value}%";

        $this->builder->where(function ($q) use ($like): void {
            $q->where('nombre', 'like', $like)
              ->orWhere('apellido_paterno', 'like', $like)
              ->orWhere('apellido_materno', 'like', $like);
        });
    }

    /**
     * Filtro por email exacto (case-insensitive).
     */
    public function email(string $value): void
    {
        $this->builder->where('email', 'like', "%{$value}%");
    }

    /**
     * Filtro por RFC exacto (case-insensitive).
     */
    public function rfc(string $value): void
    {
        $this->builder->where('rfc', 'like', strtoupper($value) . '%');
    }

    /**
     * Filtro por teléfono.
     */
    public function telefono(string $value): void
    {
        $this->builder->where('telefono', 'like', "%{$value}%");
    }

    /**
     * Búsqueda global: nombre, email, teléfono, RFC.
     */
    public function buscar(string $value): void
    {
        $like = "%{$value}%";

        $this->builder->where(function ($q) use ($like): void {
            $q->where('nombre', 'like', $like)
              ->orWhere('apellido_paterno', 'like', $like)
              ->orWhere('apellido_materno', 'like', $like)
              ->orWhere('email', 'like', $like)
              ->orWhere('telefono', 'like', $like)
              ->orWhere('rfc', 'like', $like);
        });
    }
}
