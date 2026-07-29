<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductosController extends Controller
{
    public function invoke()
    {
        return Inertia::render('productos');
    }
}
