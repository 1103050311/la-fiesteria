<?php

declare(strict_types=1);

namespace App\Modules\Shared\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Garantiza respuestas JSON uniformes en todos los Controllers de la API.
 *
 * Estructura de éxito:  { success, message, data }
 * Estructura de error:  { success, message, errors }
 * Estructura paginada:  { success, message, data, meta, links }
 */
trait ApiResponseTrait
{
    /**
     * Respuesta de éxito genérica.
     */
    protected function success(
        mixed $data = null,
        string $message = 'OK',
        int $status = 200,
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    /**
     * Respuesta de recurso creado (201).
     */
    protected function created(
        mixed $data = null,
        string $message = 'Recurso creado correctamente.',
    ): JsonResponse {
        return $this->success($data, $message, 201);
    }

    /**
     * Respuesta sin contenido (204).
     */
    protected function noContent(
        string $message = 'Operación realizada correctamente.',
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => null,
        ], 200);
    }

    /**
     * Respuesta de error genérica.
     */
    protected function error(
        string $message = 'Ha ocurrido un error.',
        mixed $errors = null,
        int $status = 400,
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }

    /**
     * Respuesta para colección paginada con meta y links de paginación.
     *
     * @param  ResourceCollection|LengthAwarePaginator  $resource
     */
    protected function paginated(
        ResourceCollection $resource,
        string $message = 'OK',
    ): JsonResponse {
        $paginator = $resource->resource;

        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $resource->collection,
            'meta'    => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
            ],
            'links' => [
                'first' => $paginator->url(1),
                'last'  => $paginator->url($paginator->lastPage()),
                'prev'  => $paginator->previousPageUrl(),
                'next'  => $paginator->nextPageUrl(),
            ],
        ], 200);
    }
}
