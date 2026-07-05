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
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('renta_id')
                ->constrained('rentas')
                ->restrictOnDelete()
                ->comment('Renta a la que corresponde esta entrega');
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete()
                ->comment('Empleado (usuario del sistema) que realizó la entrega');
            $table->dateTime('fecha')->comment('Fecha y hora exacta en que se realizó la entrega');
            $table->string('persona_recibe', 200)->comment('Nombre completo de la persona que recibe el equipo');
            $table->text('observaciones')->nullable()->comment('Observaciones de la entrega');
            $table->string('firma')->nullable()->comment('Path o base64 de la firma digital del receptor');
            $table->timestamps();

            $table->index('renta_id', 'idx_entregas_renta');
            $table->index('user_id', 'idx_entregas_usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};
