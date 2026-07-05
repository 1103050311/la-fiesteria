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
        Schema::create('detalle_compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')
                ->constrained('compras')
                ->cascadeOnDelete()
                ->comment('Compra a la que pertenece este renglón');
            $table->foreignId('producto_id')
                ->constrained('productos')
                ->restrictOnDelete()
                ->comment('Producto adquirido');
            $table->unsignedInteger('cantidad')->comment('Cantidad de unidades compradas');
            $table->decimal('precio_unitario', 10, 2)->comment('Precio unitario de compra al proveedor');
            $table->decimal('subtotal', 10, 2)->comment('Subtotal del renglón (cantidad × precio_unitario)');
            $table->timestamps();

            $table->index('compra_id', 'idx_det_compra_compra');
            $table->index('producto_id', 'idx_det_compra_producto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_compras');
    }
};
