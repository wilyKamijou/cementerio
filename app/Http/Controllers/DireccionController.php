<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Direccion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DireccionController extends Controller
{
    public function index()
    {
        $direcciones = Direccion::all();
        return response()->json($direcciones);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'seccion' => 'required|string|max:100',
                'numero' => 'required|string|max:50',
                'calle' => 'required|string|max:100',
                'fila' => 'required|string|max:50',
            ]);

            $direccion = Direccion::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Dirección creada exitosamente',
                'direccion' => $direccion
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear dirección'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $direccion = Direccion::findOrFail($id);
            return response()->json($direccion);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dirección no encontrada'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $direccion = Direccion::findOrFail($id);

            $request->validate([
                'seccion' => 'required|string|max:100',
                'numero' => 'required|string|max:50',
                'calle' => 'required|string|max:100',
                'fila' => 'required|string|max:50',
            ]);

            $direccion->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Dirección actualizada exitosamente'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar dirección'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $direccion = Direccion::findOrFail($id);
            $direccion->delete();

            return response()->json([
                'success' => true,
                'message' => 'Dirección eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar dirección'
            ], 500);
        }
    }
}
