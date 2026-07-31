<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhapiService;

class TestWhatsapp extends Command
{
    /**
     * Execute the console command.
     */
    protected $signature = 'whatsapp:test {numero} {mensaje=Hola desde Laravel}';
    protected $description = 'Envía un mensaje de prueba por WhatsApp';

    public function handle(WhapiService $whapi)
    {
        $numero = $this->argument('numero');
        $mensaje = $this->argument('mensaje');

        $resultado = $whapi->sendText($numero, $mensaje);

        $this->info(json_encode($resultado, JSON_PRETTY_PRINT));
    }

}
