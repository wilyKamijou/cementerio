<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SepultureroController extends Controller
{
    public function dashboard()
    {
        // Datos de ejemplo (reemplazar con consultas reales a tu BD)
        $espaciosTotales = 1247;
        $espaciosDisponibles = 342;
        $contratosActivos = 856;
        $ventasMes = '$245K';
        
        return view('sepulturero.dashboard', compact(
            'espaciosTotales',
            'espaciosDisponibles',
            'contratosActivos',
            'ventasMes'
        ));
    }
    
    public function contratos()
    {
        return view('sepulturero.contratos');
    }
    
    public function inhumaciones()
    {
        return view('sepulturero.inhumaciones');
    }
    
    public function mantenimiento()
    {
        return view('sepulturero.mantenimiento');
    }
    
    public function ventas()
    {
        return view('sepulturero.ventas');
    }
    
    public function clientes()
    {
        return view('sepulturero.clientes');
    }
}