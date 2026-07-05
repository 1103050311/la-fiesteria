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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->comment('Nombre o razón social del proveedor');
            $table->string('telefono', 20)->nullable()->comment('Teléfono de contacto');
            $table->string('email', 150)->nullable()->unique()->comment('Correo electrónico del proveedor');
            $table->text('direccion')->nullable()->comment('Dirección del proveedor');
            $table->text('observaciones')->nullable()->comment('Observaciones generales');
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre', 'idx_proveedores_nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
