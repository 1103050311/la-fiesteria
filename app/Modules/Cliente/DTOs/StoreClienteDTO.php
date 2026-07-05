<?php

declare(strict_types=1);

namespace App\Modules\Cliente\DTOs;

use App\Modules\Cliente\Requests\StoreClienteRequest;

/**
 * DTO inmutable para la creación de un Cliente.
 * Actúa como contrato entre el Controller/Request y el Service.
 */
final readonly class StoreClienteDTO
{
    public function __construct(
        public string  $nombre,
        public string  $apellidoPaterno,
        public ?string $apellidoMaterno,
        public ?string $telefono,
        public ?string $email,
        public ?string $rfc,
        public ?string $observaciones,
    ) {}

    /**
     * Construir desde un Form Request validado.
     */
    public static function fromRequest(StoreClienteRequest $request): self
    {
        return new self(
            nombre:          $request->string('nombre')->toString(),
            apellidoPaterno: $request->string('apellido_paterno')->toString(),
            apellidoMaterno: $request->string('apellido_materno')->value(),
            telefono:        $request->string('telefono')->value(),
            email:           $request->string('email')->value(),
            rfc:             $request->string('rfc')->value(),
            observaciones:   $request->string('observaciones')->value(),
        );
    }

    /**
     * Convertir a array para la capa de persistencia.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'nombre'           => $this->nombre,
            'apellido_paterno' => $this->apellidoPaterno,
            'apellido_materno' => $this->apellidoMaterno,
            'telefono'         => $this->telefono,
            'email'            => $this->email,
            'rfc'              => $this->rfc,
            'observaciones'    => $this->observaciones,
        ];
    }
}
