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
        Schema::create('detalle_rentas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('renta_id')
                ->constrained('rentas')
                ->cascadeOnDelete()
                ->comment('Renta a la que pertenece este renglón');
            $table->foreignId('producto_id')
                ->constrained('productos')
                ->restrictOnDelete()
                ->comment('Producto rentado (referencia al catálogo)');
            $table->foreignId('inventario_id')
                ->nullable()
                ->constrained('inventarios')
                ->nullOnDelete()
                ->comment('Unidad física específica asignada — nullable si aún no se asigna unidad');
            $table->unsignedInteger('cantidad')->comment('Cantidad de unidades rentadas');
            $table->decimal('precio_unitario', 10, 2)->comment('Precio de renta por unidad al momento de la renta');
            $table->decimal('subtotal', 10, 2)->comment('Subtotal del renglón (cantidad × precio_unitario)');
            $table->timestamps();

            $table->index('renta_id', 'idx_det_renta_renta');
            $table->index('producto_id', 'idx_det_renta_producto');
            $table->index('inventario_id', 'idx_det_renta_inventario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_rentas');
    }
};
