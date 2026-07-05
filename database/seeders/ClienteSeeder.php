<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Direccion;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Crear clientes de prueba con sus direcciones.
     */
    public function run(): void
    {
        Cliente::factory()
            ->count(20)
            ->create()
            ->each(function (Cliente $cliente): void {
                // Dirección principal
                Direccion::create([
                    'cliente_id'   => $cliente->id,
                    'calle'        => fake()->streetName(),
                    'numero'       => fake()->buildingNumber(),
                    'colonia'      => fake()->words(2, true),
                    'ciudad'       => fake()->city(),
                    'estado'       => fake('es_MX')->state(),
                    'codigo_postal' => fake()->numerify('#####'),
                    'referencia'   => fake()->optional(0.6)->sentence(),
                    'principal'    => true,
                ]);

                // Dirección adicional opcional
                if (fake()->boolean(40)) {
                    Direccion::create([
                        'cliente_id'   => $cliente->id,
                        'calle'        => fake()->streetName(),
                        'numero'       => fake()->buildingNumber(),
                        'colonia'      => fake()->words(2, true),
                        'ciudad'       => fake()->city(),
                        'estado'       => fake('es_MX')->state(),
                        'codigo_postal' => fake()->numerify('#####'),
                        'referencia'   => fake()->optional(0.4)->sentence(),
                        'principal'    => false,
                    ]);
                }
            });

        $this->command->info('✓ 20 clientes sembrados con direcciones.');
    }
}
