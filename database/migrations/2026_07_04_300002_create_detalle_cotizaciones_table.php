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
        Schema::create('detalle_cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')
                ->constrained('cotizaciones')
                ->cascadeOnDelete()
                ->comment('Cotización a la que pertenece este renglón');
            $table->foreignId('producto_id')
                ->constrained('productos')
                ->restrictOnDelete()
                ->comment('Producto cotizado');
            $table->unsignedInteger('cantidad')->comment('Cantidad de unidades cotizadas');
            $table->decimal('precio_unitario', 10, 2)->comment('Precio de renta por unidad al momento de cotizar');
            $table->decimal('subtotal', 10, 2)->comment('Subtotal del renglón (cantidad × precio_unitario)');
            $table->timestamps();

            $table->index('cotizacion_id', 'idx_det_cot_cotizacion');
            $table->index('producto_id', 'idx_det_cot_producto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_cotizaciones');
    }
};
