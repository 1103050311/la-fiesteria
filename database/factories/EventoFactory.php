<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Evento;
use App\Models\TipoEvento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Evento>
 */
class EventoFactory extends Factory
{
    protected $model = Evento::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $horaInicio = fake()->time('H:i:s');

        return [
            'cliente_id'    => Cliente::factory(),
            'tipo_evento_id' => TipoEvento::query()->inRandomOrder()->value('id') ?? 1,
            'nombre'        => fake()->sentence(4),
            'fecha'         => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'hora_inicio'   => $horaInicio,
            'hora_fin'      => fake()->optional(0.8)->time('H:i:s'),
            'direccion'     => fake()->address(),
            'invitados'     => fake()->optional(0.9)->numberBetween(20, 500),
            'observaciones' => fake()->optional(0.4)->paragraph(),
        ];
    }

    /**
     * Evento en el pasado.
     */
    public function pasado(): static
    {
        return $this->state([
            'fecha' => fake()->dateTimeBetween('-1 year', '-1 day')->format('Y-m-d'),
        ]);
    }

    /**
     * Evento próximo (en los siguientes 30 días).
     */
    public function proximo(): static
    {
        return $this->state([
            'fecha' => fake()->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
        ]);
    }
}
