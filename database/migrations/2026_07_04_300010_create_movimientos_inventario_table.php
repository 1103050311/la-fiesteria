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
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventario_id')
                ->constrained('inventarios')
                ->restrictOnDelete()
                ->comment('Unidad física que registra el movimiento');
            $table->foreignId('tipo_movimiento_id')
                ->constrained('tipos_movimiento')
                ->restrictOnDelete()
                ->comment('Tipo de movimiento realizado');
            $table->foreignId('renta_id')
                ->nullable()
                ->constrained('rentas')
                ->nullOnDelete()
                ->comment('Renta asociada al movimiento (si aplica)');
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete()
                ->comment('Usuario que registró el movimiento');
            $table->dateTime('fecha')->comment('Fecha y hora exacta del movimiento');
            $table->text('observaciones')->nullable()->comment('Observaciones del movimiento');
            $table->timestamps();

            $table->index('inventario_id', 'idx_mov_inv_inventario');
            $table->index('tipo_movimiento_id', 'idx_mov_inv_tipo');
            $table->index('renta_id', 'idx_mov_inv_renta');
            $table->index('user_id', 'idx_mov_inv_usuario');
            $table->index('fecha', 'idx_mov_inv_fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};
