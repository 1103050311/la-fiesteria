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
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventario_id')
                ->constrained('inventarios')
                ->restrictOnDelete()
                ->comment('Unidad física que recibe el mantenimiento');
            $table->foreignId('tipo_mantenimiento_id')
                ->constrained('tipos_mantenimiento')
                ->restrictOnDelete()
                ->comment('Tipo de mantenimiento realizado');
            $table->date('fecha')->comment('Fecha en que se realizó el mantenimiento');
            $table->text('descripcion')->nullable()->comment('Descripción del trabajo de mantenimiento realizado');
            $table->decimal('costo', 10, 2)->default(0)->comment('Costo del mantenimiento');
            $table->date('proximo_mantenimiento')->nullable()->comment('Fecha programada para el próximo mantenimiento');
            $table->timestamps();

            $table->index('inventario_id', 'idx_mantenimientos_inventario');
            $table->index('tipo_mantenimiento_id', 'idx_mantenimientos_tipo');
            $table->index('fecha', 'idx_mantenimientos_fecha');
            $table->index('proximo_mantenimiento', 'idx_mantenimientos_proximo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
