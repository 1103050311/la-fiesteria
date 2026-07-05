<?php

declare(strict_types=1);

namespace App\Modules\Cliente\DTOs;

use App\Modules\Cliente\Requests\UpdateClienteRequest;

/**
 * DTO inmutable para la actualización de un Cliente.
 * Todos los campos son opcionales para soportar actualizaciones parciales.
 */
final readonly class UpdateClienteDTO
{
    public function __construct(
        public ?string $nombre,
        public ?string $apellidoPaterno,
        public ?string $apellidoMaterno,
        public ?string $telefono,
        public ?string $email,
        public ?string $rfc,
        public ?string $observaciones,
    ) {}

    /**
     * Construir desde un Form Request validado.
     */
    public static function fromRequest(UpdateClienteRequest $request): self
    {
        return new self(
            nombre:          $request->string('nombre')->value(),
            apellidoPaterno: $request->string('apellido_paterno')->value(),
            apellidoMaterno: $request->string('apellido_materno')->value(),
            telefono:        $request->string('telefono')->value(),
            email:           $request->string('email')->value(),
            rfc:             $request->string('rfc')->value(),
            observaciones:   $request->string('observaciones')->value(),
        );
    }

    /**
     * Solo retorna los campos que tienen valor (para updates parciales seguros).
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'nombre'           => $this->nombre,
            'apellido_paterno' => $this->apellidoPaterno,
            'apellido_materno' => $this->apellidoMaterno,
            'telefono'         => $this->telefono,
            'email'            => $this->email,
            'rfc'              => $this->rfc,
            'observaciones'    => $this->observaciones,
        ], fn (mixed $v) => $v !== null);
    }
}
