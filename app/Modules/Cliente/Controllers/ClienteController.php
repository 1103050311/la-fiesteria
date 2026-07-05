<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Controllers;

use App\Modules\Cliente\DTOs\StoreClienteDTO;
use App\Modules\Cliente\DTOs\UpdateClienteDTO;
use App\Modules\Cliente\Filters\ClienteQueryFilter;
use App\Modules\Cliente\Requests\StoreClienteRequest;
use App\Modules\Cliente\Requests\UpdateClienteRequest;
use App\Modules\Cliente\Resources\ClienteCollection;
use App\Modules\Cliente\Resources\ClienteResource;
use App\Modules\Cliente\Services\ClienteService;
use App\Modules\Shared\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Controller del módulo Cliente.
 *
 * Responsabilidades:
 *  1. Autorizar la acción (via Policy).
 *  2. Construir el DTO desde el Request validado.
 *  3. Delegar al Service.
 *  4. Retornar la respuesta JSON usando ApiResponseTrait.
 *
 * NUNCA contiene lógica de negocio.
 */
final class ClienteController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private readonly ClienteService $service,
    ) {}

    /**
     * GET /api/v1/clientes
     *
     * Listar clientes paginados con filtros opcionales.
     * Soporta: ?buscar=, ?nombre=, ?email=, ?rfc=, ?telefono=, ?per_page=
     */
    public function index(Request $request, ClienteQueryFilter $filter): JsonResponse
    {
        $this->authorize('viewAny', \App\Models\Cliente::class);

        $perPage = (int) $request->get('per_page', 15);

        $result = $this->service->index($filter, ['direccionPrincipal'], $perPage);

        return $this->paginated(
            new ClienteCollection($result),
            'Clientes obtenidos correctamente.',
        );
    }

    /**
     * POST /api/v1/clientes
     *
     * Crear un nuevo cliente.
     */
    public function store(StoreClienteRequest $request): JsonResponse
    {
        $this->authorize('create', \App\Models\Cliente::class);

        $cliente = $this->service->store(
            StoreClienteDTO::fromRequest($request),
        );

        return $this->created(
            new ClienteResource($cliente),
            'Cliente creado correctamente.',
        );
    }

    /**
     * GET /api/v1/clientes/{cliente}
     *
     * Mostrar un cliente con todas sus direcciones.
     */
    public function show(int $cliente): JsonResponse
    {
        $model = $this->service->show($cliente, ['direcciones']);

        $this->authorize('view', $model);

        return $this->success(
            new ClienteResource($model),
            'Cliente obtenido correctamente.',
        );
    }

    /**
     * PUT /api/v1/clientes/{cliente}
     *
     * Actualizar un cliente existente.
     */
    public function update(UpdateClienteRequest $request, int $cliente): JsonResponse
    {
        $model = $this->service->show($cliente);

        $this->authorize('update', $model);

        $updated = $this->service->update(
            $cliente,
            UpdateClienteDTO::fromRequest($request),
        );

        return $this->success(
            new ClienteResource($updated),
            'Cliente actualizado correctamente.',
        );
    }

    /**
     * DELETE /api/v1/clientes/{cliente}
     *
     * Soft-delete de un cliente.
     * Regla de negocio: no se puede eliminar si tiene rentas activas.
     */
    public function destroy(int $cliente): JsonResponse
    {
        $model = $this->service->show($cliente);

        $this->authorize('delete', $model);

        $this->service->destroy($cliente);

        return $this->noContent('Cliente eliminado correctamente.');
    }
}
