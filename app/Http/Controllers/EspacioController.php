<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cementerio;
use App\Models\Dimension;
use App\Models\Direccion;
use App\Models\Inhumacion;
use App\Models\Espacio;
use App\Models\Mantenimiento;
use App\Models\TipoInhumacion;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EspacioController extends Controller
{
    public function index()
    {
        $espacios = Espacio::all();
        $cementerios = Cementerio::all();
        $dimensiones = Dimension::all();
        $direcciones = Direccion::all();
        $tipos = TipoInhumacion::all();
        $mantenimientos = Mantenimiento::all();
        $inhumaciones = Inhumacion::with(['espacio', 'tipo'])->get();
        return view('espacios.admin-espacio', compact('inhumaciones', 'espacios', 'dimensiones', 'direcciones', 'cementerios', 'mantenimientos', 'tipos'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'paterno' => 'required|string|max:255',
                'materno' => 'nullable|string|max:255',
                'fechaNaci' => 'nullable|date',
                'fechaDefun' => 'required|date',
                'fechaInhuma' => 'required|date',
                'causaMuer' => 'nullable|string',
                'idEspacio' => 'required|exists:espacios,idEspacio',
                'idTipo' => 'required|exists:tipoInhumacion,idTipo',
            ]);

            $inhumacion = Inhumacion::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Inhumación registrada exitosamente',
                'inhumacion' => $inhumacion
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar inhumación'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $inhumacion = Inhumacion::with(['espacio', 'tipo'])->findOrFail($id);
            return response()->json($inhumacion);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Inhumación no encontrada'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $inhumacion = Inhumacion::findOrFail($id);

            $request->validate([
                'nombre' => 'required|string|max:255',
                'paterno' => 'required|string|max:255',
                'materno' => 'nullable|string|max:255',
                'fechaNaci' => 'nullable|date',
                'fechaDefun' => 'required|date',
                'fechaInhuma' => 'required|date',
                'causaMuer' => 'nullable|string',
                'idEspacio' => 'required|exists:espacios,idEspacio',
                'idTipo' => 'required|exists:tipoInhumacion,idTipo',
            ]);

            $inhumacion->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Inhumación actualizada exitosamente'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar inhumación'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $inhumacion = Inhumacion::findOrFail($id);
            $inhumacion->delete();

            return response()->json([
                'success' => true,
                'message' => 'Inhumación eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar inhumación'
            ], 500);
        }
    }
}
