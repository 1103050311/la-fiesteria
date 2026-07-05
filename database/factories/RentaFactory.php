<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\EstadoRenta;
use App\Models\Renta;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Renta>
 */
class RentaFactory extends Factory
{
    protected $model = Renta::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal    = fake()->randomFloat(2, 500, 50000);
        $descuento   = fake()->randomFloat(2, 0, $subtotal * 0.2);
        $iva         = ($subtotal - $descuento) * 0.16;
        $total       = ($subtotal - $descuento) + $iva;
        $fechaRenta  = fake()->dateTimeBetween('-1 year', 'now');
        $fechaEntrega = fake()->dateTimeBetween($fechaRenta->format('Y-m-d'), '+30 days');
        $suffix      = str_pad((string) fake()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT);

        return [
            'cliente_id'       => Cliente::factory(),
            'evento_id'        => null,
            'cotizacion_id'    => null,
            'usuario_id'       => User::factory(),
            'estado_renta_id'  => EstadoRenta::CONFIRMADA,
            'folio'            => 'RNT-' . now()->format('Ymd') . '-' . $suffix,
            'fecha_renta'      => $fechaRenta->format('Y-m-d'),
            'fecha_entrega'    => $fechaEntrega->format('Y-m-d'),
            'fecha_devolucion' => null,
            'subtotal'         => $subtotal,
            'descuento'        => $descuento,
            'iva'              => $iva,
            'total'            => $total,
            'notas_internas'   => fake()->optional(0.3)->sentence(),
        ];
    }

    /**
     * Renta entregada al cliente.
     */
    public function entregada(): static
    {
        return $this->state(['estado_renta_id' => EstadoRenta::ENTREGADA]);
    }

    /**
     * Renta finalizada (devuelta y cerrada).
     */
    public function finalizada(): static
    {
        return $this->state([
            'estado_renta_id'  => EstadoRenta::FINALIZADA,
            'fecha_devolucion' => fake()->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
        ]);
    }

    /**
     * Renta cancelada.
     */
    public function cancelada(): static
    {
        return $this->state(['estado_renta_id' => EstadoRenta::CANCELADA]);
    }
}
