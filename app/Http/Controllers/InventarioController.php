<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Inventario;

use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function invoke()
    {
        $inventarios = Inventario::with(['producto', 'estadoInventario'])->get();

        return Inertia::render('inventario', [
            'inventarios' => $inventarios,
        ]);
    }

    public function create(Request $request)
    {

        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'estado_inventario_id' => 'required|exists:estado_inventarios,id',
            'piezasDisponibles' => 'required|integer|min:0',
            'piezasTotales' => 'required|integer|min:0',
            'numero_serie' => 'nullable|string|max:100|unique:inventarios,numero_serie',
            'codigo_interno' => 'required|string|max:50|unique:inventarios,codigo_interno',
            'ubicacion' => 'nullable|string|max:200',
            'fecha_compra' => 'nullable|date',
        ]);

        $inventario = Inventario::create(
            $request->only([
                'producto_id',
                'estado_inventario_id',
                'piezasDisponibles',
                'piezasTotales',
                'numero_serie',
                'codigo_interno',
                'ubicacion',
                'fecha_compra',
            ])
        );

        return response()->json($inventario, 201);
    }

    public function update(Request $request, Inventario $inventario)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'estado_inventario_id' => 'required|exists:estado_inventarios,id',
            'piezasDisponibles' => 'required|integer|min:0',
            'piezasTotales' => 'required|integer|min:0',
            'numero_serie' => 'nullable|string|max:100|unique:inventarios,numero_serie,' . $inventario->id,
            'codigo_interno' => 'required|string|max:50|unique:inventarios,codigo_interno,' . $inventario->id,
            'ubicacion' => 'nullable|string|max:200',
            'fecha_compra' => 'nullable|date',
        ]);

        $inventario->update(
            $request->only([
                'producto_id',
                'estado_inventario_id',
                'piezasDisponibles',
                'piezasTotales',
                'numero_serie',
                'codigo_interno',
                'ubicacion',
                'fecha_compra',
            ])
        );

        return response()->json($inventario);
    }

}
