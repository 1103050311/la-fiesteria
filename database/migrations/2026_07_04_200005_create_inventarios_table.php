<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')
                ->constrained('productos')
                ->restrictOnDelete()
                ->comment('Producto al que pertenece esta unidad física');
            $table->foreignId('estado_inventario_id')
                ->constrained('estados_inventario')
                ->restrictOnDelete()
                ->comment('Estado actual de la unidad física');
            $table->string('numero_serie', 100)->nullable()->unique()->comment('Número de serie del equipo (si aplica)');
            $table->integer('piezasDisponibles')->unsigned()->comment('Número de piezas disponibles');
            $table->integer('piezasTotales')->unsigned()->comment('Número total de piezas');
            $table->string('codigo_interno', 50)->unique()->comment('Código interno de identificación de la unidad');
            $table->string('ubicacion', 200)->nullable()->comment('Ubicación física actual del equipo en almacén');
            $table->date('fecha_compra')->nullable()->comment('Fecha de adquisición del equipo');
            $table->timestamps();
            $table->softDeletes();

            $table->index('producto_id', 'idx_inventarios_producto');
            $table->index('estado_inventario_id', 'idx_inventarios_estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
