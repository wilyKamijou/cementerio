<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return response()->json($empleados);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'paterno' => 'required|string|max:255',
            'materno' => 'nullable|string|max:255',
            'direccion' => 'nullable|string',
            'telefono' => 'required|string|max:20'
        ]);

        $empleado = Empleado::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Empleado creado exitosamente',
            'empleado' => $empleado
        ]);
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'paterno' => 'required|string|max:255',
            'materno' => 'nullable|string|max:255',
            'direccion' => 'nullable|string',
            'telefono' => 'required|string|max:20'
        ]);

        $empleado->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Empleado actualizado exitosamente'
        ]);
    }

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return response()->json([
            'success' => true,
            'message' => 'Empleado eliminado exitosamente'
        ]);
    }

    public function show($id)
    {
        $empleado = Empleado::findOrFail($id);
        return response()->json($empleado);
    }
}
