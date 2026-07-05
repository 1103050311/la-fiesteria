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
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('renta_id')
                ->constrained('rentas')
                ->restrictOnDelete()
                ->comment('Renta a la que corresponde esta devolución');
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete()
                ->comment('Empleado (usuario del sistema) que registró la devolución');
            $table->dateTime('fecha')->comment('Fecha y hora exacta de la devolución del equipo');
            $table->text('observaciones')->nullable()->comment('Observaciones de la devolución (estado general del equipo, etc.)');
            $table->timestamps();

            $table->index('renta_id', 'idx_devoluciones_renta');
            $table->index('user_id', 'idx_devoluciones_usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devoluciones');
    }
};
