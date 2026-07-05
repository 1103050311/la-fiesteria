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
        Schema::create('rentas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->restrictOnDelete()
                ->comment('Cliente que realiza la renta');
            $table->foreignId('evento_id')
                ->nullable()
                ->constrained('eventos')
                ->nullOnDelete()
                ->comment('Evento al que corresponde la renta (opcional)');
            $table->foreignId('cotizacion_id')
                ->nullable()
                ->constrained('cotizaciones')
                ->nullOnDelete()
                ->comment('Cotización de origen si la renta surgió de una cotización previa');
            $table->foreignId('usuario_id')
                ->constrained('users')
                ->restrictOnDelete()
                ->comment('Usuario que registró la renta');
            $table->foreignId('estado_renta_id')
                ->constrained('estados_renta')
                ->restrictOnDelete()
                ->comment('Estado actual de la renta');
            $table->string('folio', 30)->unique()->comment('Folio único (RNT-YYYYMMDD-XXXX) generado automáticamente');
            $table->date('fecha_renta')->comment('Fecha en que se registra la renta');
            $table->date('fecha_entrega')->comment('Fecha programada de entrega del equipo al cliente');
            $table->date('fecha_devolucion')->nullable()->comment('Fecha real en que se devolvió el equipo');
            $table->decimal('subtotal', 10, 2)->default(0)->comment('Subtotal antes de descuento e IVA');
            $table->decimal('descuento', 10, 2)->default(0)->comment('Monto de descuento aplicado');
            $table->decimal('iva', 10, 2)->default(0)->comment('IVA calculado');
            $table->decimal('total', 10, 2)->default(0)->comment('Total a cobrar al cliente');
            $table->text('notas_internas')->nullable()->comment('Notas internas del personal (NO visibles al cliente)');
            $table->timestamps();
            // Sin softDeletes — las rentas NUNCA se eliminan por integridad del historial

            $table->index('cliente_id', 'idx_rentas_cliente');
            $table->index('evento_id', 'idx_rentas_evento');
            $table->index('cotizacion_id', 'idx_rentas_cotizacion');
            $table->index('usuario_id', 'idx_rentas_usuario');
            $table->index('estado_renta_id', 'idx_rentas_estado');
            $table->index('fecha_renta', 'idx_rentas_fecha_renta');
            $table->index('fecha_entrega', 'idx_rentas_fecha_entrega');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentas');
    }
};
