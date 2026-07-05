<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\EstadoInventario;
use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inventario>
 */
class InventarioFactory extends Factory
{
    protected $model = Inventario::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'producto_id'          => Producto::factory(),
            'estado_inventario_id' => EstadoInventario::DISPONIBLE,
            'numero_serie'         => fake()->optional(0.7)->unique()->bothify('SN-######-??'),
            'codigo_interno'       => strtoupper(fake()->unique()->bothify('INV-######')),
            'ubicacion'            => fake()->optional(0.8)->randomElement([
                'Almacén A', 'Almacén B', 'Bodega Principal',
                'Estantería 1', 'Estantería 2', 'Rack 3',
            ]),
            'fecha_compra' => fake()->optional(0.8)->dateTimeBetween('-5 years', 'now')?->format('Y-m-d'),
        ];
    }

    /**
     * Unidad en estado Disponible.
     */
    public function disponible(): static
    {
        return $this->state(['estado_inventario_id' => EstadoInventario::DISPONIBLE]);
    }

    /**
     * Unidad en estado Rentado.
     */
    public function rentado(): static
    {
        return $this->state(['estado_inventario_id' => EstadoInventario::RENTADO]);
    }

    /**
     * Unidad en estado Mantenimiento.
     */
    public function enMantenimiento(): static
    {
        return $this->state(['estado_inventario_id' => EstadoInventario::MANTENIMIENTO]);
    }

    /**
     * Unidad dañada.
     */
    public function danado(): static
    {
        return $this->state(['estado_inventario_id' => EstadoInventario::DANADO]);
    }
}
