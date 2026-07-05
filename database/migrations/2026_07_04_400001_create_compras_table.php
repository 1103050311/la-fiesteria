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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')
                ->constrained('proveedores')
                ->restrictOnDelete()
                ->comment('Proveedor al que se realizó la compra');
            $table->string('numero_factura', 100)->nullable()->comment('Número de factura del proveedor');
            $table->date('fecha')->comment('Fecha de la compra');
            $table->decimal('total', 10, 2)->default(0)->comment('Total de la compra');
            $table->text('observaciones')->nullable()->comment('Observaciones de la compra');
            $table->timestamps();
            $table->softDeletes();

            $table->index('proveedor_id', 'idx_compras_proveedor');
            $table->index('fecha', 'idx_compras_fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
