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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->restrictOnDelete()
                ->comment('Cliente al que pertenece la cotización');
            $table->foreignId('evento_id')
                ->nullable()
                ->constrained('eventos')
                ->nullOnDelete()
                ->comment('Evento relacionado con la cotización (opcional)');
            $table->foreignId('usuario_id')
                ->constrained('users')
                ->restrictOnDelete()
                ->comment('Usuario que generó la cotización');
            $table->foreignId('estado_cotizacion_id')
                ->constrained('estados_cotizacion')
                ->restrictOnDelete()
                ->comment('Estado actual de la cotización');
            $table->string('folio', 30)->unique()->comment('Folio único (COT-YYYYMMDD-XXXX) generado automáticamente');
            $table->date('fecha')->comment('Fecha de generación de la cotización');
            $table->decimal('subtotal', 10, 2)->default(0)->comment('Subtotal antes de descuento e IVA');
            $table->decimal('descuento', 10, 2)->default(0)->comment('Monto de descuento aplicado');
            $table->decimal('iva', 10, 2)->default(0)->comment('IVA calculado');
            $table->decimal('total', 10, 2)->default(0)->comment('Total a pagar por el cliente');
            $table->text('observaciones')->nullable()->comment('Observaciones visibles al cliente');
            $table->timestamps();
            $table->softDeletes();

            $table->index('cliente_id', 'idx_cotizaciones_cliente');
            $table->index('evento_id', 'idx_cotizaciones_evento');
            $table->index('usuario_id', 'idx_cotizaciones_usuario');
            $table->index('estado_cotizacion_id', 'idx_cotizaciones_estado');
            $table->index('fecha', 'idx_cotizaciones_fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};
