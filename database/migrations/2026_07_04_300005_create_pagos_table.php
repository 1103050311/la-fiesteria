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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('renta_id')
                ->constrained('rentas')
                ->restrictOnDelete()
                ->comment('Renta a la que corresponde el pago');
            $table->foreignId('metodo_pago_id')
                ->constrained('metodos_pago')
                ->restrictOnDelete()
                ->comment('Método de pago utilizado');
            $table->date('fecha')->comment('Fecha en que se realizó el pago');
            $table->decimal('monto', 10, 2)->comment('Monto del pago');
            $table->string('referencia', 100)->nullable()->comment('Número de referencia, folio o comprobante del pago');
            $table->text('observaciones')->nullable()->comment('Observaciones del pago');
            $table->timestamps();

            $table->index('renta_id', 'idx_pagos_renta');
            $table->index('metodo_pago_id', 'idx_pagos_metodo');
            $table->index('fecha', 'idx_pagos_fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
