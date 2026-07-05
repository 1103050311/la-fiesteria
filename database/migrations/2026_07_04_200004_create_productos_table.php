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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->restrictOnDelete()
                ->comment('Categoría del producto');
            $table->string('codigo', 50)->unique()->comment('Código único del producto');
            $table->string('nombre', 200)->comment('Nombre descriptivo del producto');
            $table->text('descripcion')->nullable()->comment('Descripción detallada del producto');
            $table->decimal('precio_renta', 10, 2)->default(0)->comment('Precio de renta unitario por evento');
            $table->decimal('precio_reposicion', 10, 2)->default(0)->comment('Precio de reposición en caso de daño o pérdida');
            $table->boolean('requiere_mantenimiento')->default(false)->comment('Indica si el producto requiere mantenimiento periódico');
            $table->boolean('activo')->default(true)->comment('Indica si el producto está disponible en el catálogo comercial');
            $table->timestamps();
            $table->softDeletes();

            $table->index('categoria_id', 'idx_productos_categoria');
            $table->index('activo', 'idx_productos_activo');
            $table->index('nombre', 'idx_productos_nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
