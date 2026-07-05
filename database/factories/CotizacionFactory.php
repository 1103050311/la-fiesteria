<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Cotizacion;
use App\Models\EstadoCotizacion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cotizacion>
 */
class CotizacionFactory extends Factory
{
    protected $model = Cotizacion::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal  = fake()->randomFloat(2, 500, 50000);
        $descuento = fake()->randomFloat(2, 0, $subtotal * 0.2);
        $iva       = ($subtotal - $descuento) * 0.16;
        $total     = ($subtotal - $descuento) + $iva;

        $fecha  = fake()->dateTimeBetween('-6 months', 'now');
        $suffix = str_pad((string) fake()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT);

        return [
            'cliente_id'           => Cliente::factory(),
            'evento_id'            => null,
            'usuario_id'           => User::factory(),
            'estado_cotizacion_id' => EstadoCotizacion::PENDIENTE,
            'folio'                => 'COT-' . now()->format('Ymd') . '-' . $suffix,
            'fecha'                => $fecha->format('Y-m-d'),
            'subtotal'             => $subtotal,
            'descuento'            => $descuento,
            'iva'                  => $iva,
            'total'                => $total,
            'observaciones'        => fake()->optional(0.4)->sentence(),
        ];
    }

    /**
     * Cotización aceptada por el cliente.
     */
    public function aceptada(): static
    {
        return $this->state(['estado_cotizacion_id' => EstadoCotizacion::ACEPTADA]);
    }

    /**
     * Cotización rechazada.
     */
    public function rechazada(): static
    {
        return $this->state(['estado_cotizacion_id' => EstadoCotizacion::RECHAZADA]);
    }

    /**
     * Cotización expirada.
     */
    public function expirada(): static
    {
        return $this->state(['estado_cotizacion_id' => EstadoCotizacion::EXPIRADA]);
    }
}
