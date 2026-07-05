<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cliente>
 */
class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'           => fake('es_MX')->firstName(),
            'apellido_paterno' => fake('es_MX')->lastName(),
            'apellido_materno' => fake()->optional(0.8)->lastName(),
            'telefono'         => fake()->numerify('###-###-####'),
            'email'            => fake()->optional(0.9)->unique()->safeEmail(),
            'rfc'              => fake()->optional(0.5)->regexify('[A-Z]{4}[0-9]{6}[A-Z0-9]{3}'),
            'observaciones'    => fake()->optional(0.3)->sentence(),
        ];
    }

    /**
     * Cliente con email confirmado.
     */
    public function conEmail(): static
    {
        return $this->state(['email' => fake()->unique()->safeEmail()]);
    }

    /**
     * Cliente con RFC.
     */
    public function conRfc(): static
    {
        return $this->state(['rfc' => fake()->regexify('[A-Z]{4}[0-9]{6}[A-Z0-9]{3}')]);
    }
}
