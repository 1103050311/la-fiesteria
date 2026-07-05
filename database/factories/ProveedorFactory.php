<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Proveedor>
 */
class ProveedorFactory extends Factory
{
    protected $model = Proveedor::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'        => fake()->company(),
            'telefono'      => fake()->optional(0.8)->numerify('###-###-####'),
            'email'         => fake()->optional(0.7)->unique()->companyEmail(),
            'direccion'     => fake()->optional(0.8)->address(),
            'observaciones' => fake()->optional(0.3)->sentence(),
        ];
    }
}
