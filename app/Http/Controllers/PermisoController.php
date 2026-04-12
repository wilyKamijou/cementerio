<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:permisos,nombre',
            'ruta' => 'nullable|string',
            'descripcion' => 'nullable|string'
        ]);

        $permiso = Permiso::create($request->all());

        return response()->json(['success' => true, 'message' => 'Permiso creado exitosamente', 'permiso' => $permiso]);
    }
}
