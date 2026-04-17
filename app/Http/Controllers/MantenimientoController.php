<?php
// app/Http/Controllers/Admin/MantenimientoController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mantenimiento;
use App\Models\Espacio;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mantenimientos = Mantenimiento::with('espacio')->get();
        $espacios = Espacio::all();

        return view('inhumaciones.admin-inhumacion', compact('mantenimientos', 'espacios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'idEspacio' => 'required|exists:espacios,idEspacio',
                'precio' => 'required|numeric|min:0',
                'fechaMant' => 'required|date',
                'descripcion' => 'nullable|string',
                'estado' => 'nullable|string',
                'tipo' => 'required|string|max:100'
            ]);

            $mantenimiento = Mantenimiento::create([
                'idEspacio' => $request->idEspacio,
                'precio' => $request->precio,
                'fechaMant' => $request->fechaMant,
                'descripcion' => $request->descripcion,
                'estado' => $request->estado ?? 'pendiente',
                'tipo' => $request->tipo
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mantenimiento registrado exitosamente',
                'data' => $mantenimiento
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $mantenimiento = Mantenimiento::with('espacio')->findOrFail($id);

            return response()->json([
                'idMant' => $mantenimiento->idMant,
                'idEspacio' => $mantenimiento->idEspacio,
                'precio' => $mantenimiento->precio,
                'fechaMant' => $mantenimiento->fechaMant,
                'descripcion' => $mantenimiento->descripcion,
                'estado' => $mantenimiento->estado,
                'tipo' => $mantenimiento->tipo,
                'espacio_info' => $mantenimiento->espacio ? [
                    'id' => $mantenimiento->espacio->idEspacio,
                    'estado' => $mantenimiento->espacio->estado
                ] : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Mantenimiento no encontrado'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'idEspacio' => 'required|exists:espacios,idEspacio',
                'precio' => 'required|numeric|min:0',
                'fechaMant' => 'required|date',
                'descripcion' => 'nullable|string',
                'estado' => 'nullable|string',
                'tipo' => 'required|string|max:100'
            ]);

            $mantenimiento = Mantenimiento::findOrFail($id);

            $mantenimiento->update([
                'idEspacio' => $request->idEspacio,
                'precio' => $request->precio,
                'fechaMant' => $request->fechaMant,
                'descripcion' => $request->descripcion,
                'estado' => $request->estado,
                'tipo' => $request->tipo
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mantenimiento actualizado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $mantenimiento = Mantenimiento::findOrFail($id);
            $mantenimiento->delete();

            return response()->json([
                'success' => true,
                'message' => 'Mantenimiento eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }
}
