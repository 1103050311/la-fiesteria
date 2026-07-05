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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->cascadeOnDelete()
                ->comment('Cliente al que pertenece la dirección');
            $table->string('calle', 200)->comment('Nombre de la calle o avenida');
            $table->string('numero', 20)->comment('Número exterior e interior');
            $table->string('colonia', 150)->comment('Colonia o fraccionamiento');
            $table->string('ciudad', 100)->comment('Ciudad o municipio');
            $table->string('estado', 100)->comment('Estado de la república');
            $table->string('codigo_postal', 10)->comment('Código postal');
            $table->text('referencia')->nullable()->comment('Referencias adicionales para localizar el domicilio');
            $table->boolean('principal')->default(false)->comment('Indica si es la dirección principal del cliente');
            $table->timestamps();

            $table->index('cliente_id', 'idx_direcciones_cliente');
            $table->index('codigo_postal', 'idx_direcciones_cp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
