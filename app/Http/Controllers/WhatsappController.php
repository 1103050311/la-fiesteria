<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WhapiService;

class WhatsappController extends Controller
{
    public function enviar(Request $request, WhapiService $whapi)
    {
        $request->validate([
            'to' => 'required|string',
            'mensaje' => 'required|string',
        ]);

        $resultado = $whapi->sendText(
            $request->input('to'),
            $request->input('mensaje')
        );

        if (isset($resultado['sent']) && $resultado['sent']) {
            return response()->json(['status' => 'ok', 'data' => $resultado]);
        }

        return response()->json(['status' => 'error', 'data' => $resultado], 422);
    }
}
