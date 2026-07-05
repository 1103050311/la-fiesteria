<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Colección paginada de Clientes.
 */
class ClienteCollection extends ResourceCollection
{
    public string $collects = ClienteResource::class;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
}
