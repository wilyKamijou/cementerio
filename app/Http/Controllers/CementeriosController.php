<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cementerio;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CementeriosController extends Controller
{
    public function index()
    {
        $cementerios = Cementerio::all();
        return response()->json($cementerios);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'estado' => 'required|string|max:100',
                'localizacion' => 'nullable|string',
                'espacioDisp' => 'nullable|string',
            ]);

            $cementerio = Cementerio::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Cementerio creado exitosamente',
                'cementerio' => $cementerio
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear cementerio'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $cementerio = Cementerio::findOrFail($id);
            return response()->json($cementerio);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cementerio no encontrado'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $cementerio = Cementerio::findOrFail($id);

            $request->validate([
                'nombre' => 'required|string|max:255',
                'estado' => 'required|string|max:100',
                'localizacion' => 'nullable|string',
                'espacioDisp' => 'nullable|string',
            ]);

            $cementerio->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Cementerio actualizado exitosamente'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar cementerio'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $cementerio = Cementerio::findOrFail($id);
            $cementerio->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cementerio eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar cementerio'
            ], 500);
        }
    }
}
