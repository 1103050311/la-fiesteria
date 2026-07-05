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
        Schema::create('estados_inventario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique()->comment('Nombre del estado del inventario');
            $table->text('descripcion')->nullable()->comment('Descripción del estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados_inventario');
    }
};
