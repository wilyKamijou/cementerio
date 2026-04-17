<?php
// app/Http/Controllers/Admin/TipoInhumacionController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TipoInhumacion;
use Illuminate\Http\Request;

class TipoInhumacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tiposInhumacion = TipoInhumacion::all();
        return view('inhumaciones.admin-inhumacion', compact('tiposInhumacion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:100|unique:tipoInhumacion,nombre',
                'precio' => 'required|numeric|min:0',
                'capacidadMax' => 'nullable|integer|min:1',
                'estado' => 'nullable|string|in:activo,inactivo',
                'areaBase' => 'nullable|numeric|min:0'
            ]);

            $tipo = TipoInhumacion::create([
                'nombre' => $request->nombre,
                'precio' => $request->precio,
                'capacidadMax' => $request->capacidadMax ?? null,
                'estado' => $request->estado ?? 'activo',
                'areaBase' => $request->areaBase ?? null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tipo de inhumación creado exitosamente',
                'data' => $tipo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $tipo = TipoInhumacion::findOrFail($id);

            return response()->json([
                'idTipo' => $tipo->idTipo,
                'nombre' => $tipo->nombre,
                'precio' => $tipo->precio,
                'capacidadMax' => $tipo->capacidadMax,
                'estado' => $tipo->estado,
                'areaBase' => $tipo->areaBase
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tipo de inhumación no encontrado'
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
                'nombre' => 'required|string|max:100|unique:tipoInhumacion,nombre,' . $id . ',idTipo',
                'precio' => 'required|numeric|min:0',
                'capacidadMax' => 'nullable|integer|min:1',
                'estado' => 'nullable|string|in:activo,inactivo',
                'areaBase' => 'nullable|numeric|min:0'
            ]);

            $tipo = TipoInhumacion::findOrFail($id);

            $tipo->update([
                'nombre' => $request->nombre,
                'precio' => $request->precio,
                'capacidadMax' => $request->capacidadMax,
                'estado' => $request->estado,
                'areaBase' => $request->areaBase
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tipo de inhumación actualizado exitosamente'
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
            $tipo = TipoInhumacion::findOrFail($id);

            // Verificar si tiene inhumaciones asociadas
            if ($tipo->inhumaciones()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar porque tiene inhumaciones asociadas'
                ], 400);
            }

            $tipo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tipo de inhumación eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }
}
