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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->restrictOnDelete()
                ->comment('Cliente titular del evento');
            $table->foreignId('tipo_evento_id')
                ->constrained('tipos_evento')
                ->restrictOnDelete()
                ->comment('Tipo de evento (boda, quinceañera, corporativo, etc.)');
            $table->string('nombre', 200)->comment('Nombre o descripción del evento');
            $table->date('fecha')->comment('Fecha en que se realizará el evento');
            $table->time('hora_inicio')->comment('Hora de inicio del evento');
            $table->time('hora_fin')->nullable()->comment('Hora de finalización del evento');
            $table->string('direccion', 300)->comment('Dirección donde se realizará el evento');
            $table->unsignedInteger('invitados')->nullable()->comment('Número aproximado de invitados');
            $table->text('observaciones')->nullable()->comment('Observaciones adicionales del evento');
            $table->timestamps();
            $table->softDeletes();

            $table->index('cliente_id', 'idx_eventos_cliente');
            $table->index('tipo_evento_id', 'idx_eventos_tipo');
            $table->index('fecha', 'idx_eventos_fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
