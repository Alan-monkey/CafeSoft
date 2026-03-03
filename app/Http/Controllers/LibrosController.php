<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libros;

class LibrosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:usuarios');
    }
    
    public function inicio()
    {
        $user = auth()->guard('usuarios')->user();
        return view('libros.inicio', compact('user'));
    }
    
    public function inicioInv()
    {
        $user = auth()->guard('usuarios')->user();
        return view('libros.inicioInv', compact('user'));
    }
    
    // Aquí van tus otros métodos...
}