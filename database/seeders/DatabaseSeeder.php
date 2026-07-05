<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Usuario administrador por defecto
        User::firstOrCreate(
            ['email' => 'admin@lafiesteria.com'],
            [
                'name'     => 'Administrador',
                'email'    => 'admin@lafiesteria.com',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Catálogos base (sin dependencias)
        $this->call([
            CatalogoSeeder::class,
            CategoriaSeeder::class,
        ]);

        // 3. Datos de prueba (solo en entornos no productivos)
        if (! app()->isProduction()) {
            $this->call([
                ClienteSeeder::class,
            ]);
        }
    }
}
