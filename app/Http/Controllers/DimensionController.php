<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dimension;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DimensionController extends Controller
{
    public function index()
    {
        $dimensiones = Dimension::all();
        return response()->json($dimensiones);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'ancho' => 'required|numeric|min:0',
                'largo' => 'required|numeric|min:0',
            ]);

            $dimension = Dimension::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Dimensión creada exitosamente',
                'dimension' => $dimension
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear dimensión'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $dimension = Dimension::findOrFail($id);
            return response()->json($dimension);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dimensión no encontrada'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $dimension = Dimension::findOrFail($id);

            $request->validate([
                'ancho' => 'required|numeric|min:0',
                'largo' => 'required|numeric|min:0',
            ]);

            $dimension->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Dimensión actualizada exitosamente'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar dimensión'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $dimension = Dimension::findOrFail($id);
            $dimension->delete();

            return response()->json([
                'success' => true,
                'message' => 'Dimensión eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar dimensión'
            ], 500);
        }
    }
}
