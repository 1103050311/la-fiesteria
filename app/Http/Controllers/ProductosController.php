<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Producto;

class ProductosController extends Controller
{
    public function invoke()
    {
        $productos = Producto::with('categoria', 'marca')->get();

        return Inertia::render('productos', [
            'productos' => $productos,
        ]);
    }
}
