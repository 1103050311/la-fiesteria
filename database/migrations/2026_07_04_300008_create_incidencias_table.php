<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('renta_id')
                ->constrained('rentas')
                ->restrictOnDelete()
                ->comment('Renta en la que ocurrió la incidencia');
            $table->foreignId('inventario_id')
                ->constrained('inventarios')
                ->restrictOnDelete()
                ->comment('Unidad física afectada por la incidencia');
            $table->foreignId('tipo_incidencia_id')
                ->constrained('tipos_incidencia')
                ->restrictOnDelete()
                ->comment('Tipo de incidencia registrada');
            $table->text('descripcion')->comment('Descripción detallada de la incidencia');
            $table->decimal('costo', 10, 2)->default(0)->comment('Costo estimado de la incidencia (reparación, reposición, etc.)');
            $table->timestamps();

            $table->index('renta_id', 'idx_incidencias_renta');
            $table->index('inventario_id', 'idx_incidencias_inventario');
            $table->index('tipo_incidencia_id', 'idx_incidencias_tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
