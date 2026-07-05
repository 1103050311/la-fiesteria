<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Producto>
 */
class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'categoria_id'           => Categoria::factory(),
            'codigo'                 => strtoupper(fake()->unique()->bothify('??-####')),
            'nombre'                 => fake()->words(3, true),
            'descripcion'            => fake()->optional(0.7)->paragraph(),
            'precio_renta'           => fake()->randomFloat(2, 50, 5000),
            'precio_reposicion'      => fake()->randomFloat(2, 100, 20000),
            'requiere_mantenimiento' => fake()->boolean(30),
            'activo'                 => fake()->boolean(90),
        ];
    }

    /**
     * Producto activo en el catálogo.
     */
    public function activo(): static
    {
        return $this->state(['activo' => true]);
    }

    /**
     * Producto inactivo (dado de baja del catálogo).
     */
    public function inactivo(): static
    {
        return $this->state(['activo' => false]);
    }

    /**
     * Producto que requiere mantenimiento periódico.
     */
    public function conMantenimiento(): static
    {
        return $this->state(['requiere_mantenimiento' => true]);
    }
}
