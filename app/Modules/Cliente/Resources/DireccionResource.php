<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Resources;

use App\Models\Direccion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transforma un modelo Direccion a JSON.
 *
 * @mixin Direccion
 */
class DireccionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Direccion $this */
        return [
            'id'               => $this->id,
            'calle'            => $this->calle,
            'numero'           => $this->numero,
            'colonia'          => $this->colonia,
            'ciudad'           => $this->ciudad,
            'estado'           => $this->estado,
            'codigo_postal'    => $this->codigo_postal,
            'referencia'       => $this->referencia,
            'principal'        => $this->principal,
            'direccion_completa' => $this->direccion_completa,
        ];
    }
}
