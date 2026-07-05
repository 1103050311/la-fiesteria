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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->comment('Nombre(s) del cliente');
            $table->string('apellido_paterno', 100)->comment('Apellido paterno del cliente');
            $table->string('apellido_materno', 100)->nullable()->comment('Apellido materno del cliente');
            $table->string('telefono', 20)->comment('Teléfono principal de contacto');
            $table->string('email', 150)->nullable()->unique()->comment('Correo electrónico del cliente');
            $table->string('rfc', 13)->nullable()->comment('RFC del cliente o empresa');
            $table->text('observaciones')->nullable()->comment('Observaciones generales del cliente');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['apellido_paterno', 'apellido_materno'], 'idx_clientes_apellidos');
            $table->index('rfc', 'idx_clientes_rfc');
            $table->index('telefono', 'idx_clientes_telefono');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
