<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Poblar las categorías base del catálogo de productos.
     */
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Iluminación',        'descripcion' => 'Equipos y accesorios de iluminación: focos, leds, candiles, spots'],
            ['nombre' => 'Sonido',             'descripcion' => 'Equipos de audio profesional: bocinas, micrófonos, consolas, amplificadores'],
            ['nombre' => 'Mobiliario',         'descripcion' => 'Sillas, mesas, lounge, barra y mobiliario general para eventos'],
            ['nombre' => 'Carpas y Toldos',    'descripcion' => 'Carpas, gazebos, pergolas y estructuras temporales'],
            ['nombre' => 'Vajilla',            'descripcion' => 'Platos, tazas, cubiertos y utensilios de servicio de mesa'],
            ['nombre' => 'Cristalería',        'descripcion' => 'Vasos, copas, jarras y cristalería fina'],
            ['nombre' => 'Mantelería',         'descripcion' => 'Manteles, cubre sillas, caminos de mesa y servilletas'],
            ['nombre' => 'Decoración',         'descripcion' => 'Elementos decorativos, centros de mesa, arreglos y ambientación'],
            ['nombre' => 'Generadores',        'descripcion' => 'Plantas de luz, generadores eléctricos y extensiones industriales'],
            ['nombre' => 'Video y Proyección', 'descripcion' => 'Pantallas LED, proyectores, pantallas de tela y equipos de video'],
            ['nombre' => 'Pistas de Baile',    'descripcion' => 'Pistas de madera, acrílico y estructuras de piso para baile'],
            ['nombre' => 'Escenarios',         'descripcion' => 'Tarimas, escenarios modulares y estructuras de presentación'],
            ['nombre' => 'Cocina y Banquetes', 'descripcion' => 'Equipos de cocina, chafing dishes y equipos para servicio de banquetes'],
            ['nombre' => 'Otros',              'descripcion' => 'Artículos y equipo que no encajan en categorías anteriores'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::firstOrCreate(['nombre' => $categoria['nombre']], $categoria);
        }

        $this->command->info('✓ Categorías sembradas correctamente.');
    }
}
