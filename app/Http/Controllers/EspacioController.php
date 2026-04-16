<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Espacio;
use App\Models\Cementerio;
use App\Models\Dimension;
use App\Models\Direccion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EspacioController extends Controller
{
    public function index()
    {
        $espacios = Espacio::with(['direccion', 'dimension', 'cementerio'])->get();
        $cementerios = Cementerio::all();
        $dimensiones = Dimension::all();
        $direcciones = Direccion::all();

        return view('espacios.admin-espacio', compact('espacios', 'cementerios', 'dimensiones', 'direcciones'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'precio' => 'required|numeric|min:0',
                'estado' => 'required|string|max:50',
                'idDir' => 'required|exists:direcciones,idDir',
                'idDim' => 'required|exists:dimensiones,idDim',
                'idCem' => 'required|exists:cementerios,idCem',
            ]);

            $espacio = Espacio::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Espacio creado exitosamente',
                'espacio' => $espacio
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear espacio'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $espacio = Espacio::with(['direccion', 'dimension', 'cementerio'])->findOrFail($id);
            return response()->json($espacio);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Espacio no encontrado'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $espacio = Espacio::findOrFail($id);

            $request->validate([
                'precio' => 'required|numeric|min:0',
                'estado' => 'required|string|max:50',
                'idDir' => 'required|exists:direcciones,idDir',
                'idDim' => 'required|exists:dimensiones,idDim',
                'idCem' => 'required|exists:cementerios,idCem',
            ]);

            $espacio->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Espacio actualizado exitosamente'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar espacio'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $espacio = Espacio::findOrFail($id);
            $espacio->delete();

            return response()->json([
                'success' => true,
                'message' => 'Espacio eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar espacio'
            ], 500);
        }
    }
}
