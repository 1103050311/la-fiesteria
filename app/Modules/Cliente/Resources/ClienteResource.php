<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Resources;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transforma un modelo Cliente a la representación JSON de la API.
 *
 * @mixin Cliente
 */
class ClienteResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Cliente $this */
        return [
            'id'               => $this->id,
            'nombre'           => $this->nombre,
            'apellido_paterno' => $this->apellido_paterno,
            'apellido_materno' => $this->apellido_materno,
            'nombre_completo'  => $this->nombre_completo,
            'telefono'         => $this->telefono,
            'email'            => $this->email,
            'rfc'              => $this->rfc,
            'observaciones'    => $this->observaciones,
            'created_at'       => $this->created_at?->toIso8601String(),
            'updated_at'       => $this->updated_at?->toIso8601String(),

            // Relaciones condicionales (solo se incluyen si están cargadas)
            'direccion_principal' => $this->whenLoaded('direccionPrincipal', function () {
                return $this->direccionPrincipal->first()
                    ? new DireccionResource($this->direccionPrincipal->first())
                    : null;
            }),
            'direcciones' => $this->whenLoaded('direcciones', function () {
                return DireccionResource::collection($this->direcciones);
            }),
        ];
    }
}
