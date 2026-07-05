<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Controllers;

use App\Models\Cliente;
use App\Modules\Cliente\Resources\DireccionResource;
use App\Modules\Cliente\Services\ClienteService;
use App\Modules\Shared\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Controller para el recurso anidado Direcciones de un Cliente.
 *
 * Ruta: /api/v1/clientes/{cliente}/direcciones
 */
final class DireccionController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private readonly ClienteService $service,
    ) {}

    /**
     * GET /api/v1/clientes/{cliente}/direcciones
     *
     * Retorna todas las direcciones del cliente.
     */
    public function index(int $cliente): JsonResponse
    {
        $model = $this->service->show($cliente, ['direcciones']);

        $this->authorize('view', $model);

        return $this->success(
            DireccionResource::collection($model->direcciones),
            'Direcciones del cliente obtenidas correctamente.',
        );
    }
}
