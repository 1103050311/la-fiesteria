<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\MetodoPago;
use App\Models\Pago;
use App\Models\Renta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pago>
 */
class PagoFactory extends Factory
{
    protected $model = Pago::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'renta_id'       => Renta::factory(),
            'metodo_pago_id' => fake()->numberBetween(1, 5),
            'fecha'          => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'monto'          => fake()->randomFloat(2, 100, 20000),
            'referencia'     => fake()->optional(0.7)->numerify('REF-######'),
            'observaciones'  => fake()->optional(0.3)->sentence(),
        ];
    }

    /**
     * Pago en efectivo.
     */
    public function efectivo(): static
    {
        return $this->state(['metodo_pago_id' => MetodoPago::EFECTIVO]);
    }

    /**
     * Pago por transferencia bancaria.
     */
    public function transferencia(): static
    {
        return $this->state([
            'metodo_pago_id' => MetodoPago::TRANSFERENCIA,
            'referencia'     => fake()->numerify('SPEI-############'),
        ]);
    }
}
