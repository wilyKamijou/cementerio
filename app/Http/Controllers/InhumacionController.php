<?php
// app/Http/Controllers/Admin/InhumacionController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inhumacion;
use App\Models\TipoInhumacion;
use App\Models\Espacio;
use App\Models\Mantenimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InhumacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inhumaciones = Inhumacion::with(['tipo', 'espacio.direccion'])->get();
        $tiposInhumacion = TipoInhumacion::all();
        $espaciosDisponibles = Espacio::where('estado', 'disponible')->get();
        $mantenimientos = Mantenimiento::with('espacio')->get();
        $espacios = Espacio::with('direccion')->get();

        return view('inhumaciones.admin-inhumacion', compact(
            'inhumaciones',
            'tiposInhumacion',
            'espaciosDisponibles',
            'mantenimientos',
            'espacios'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:100',
                'paterno' => 'required|string|max:100',
                'materno' => 'nullable|string|max:100',
                'fechaNaci' => 'nullable|date',
                'fechaDefun' => 'required|date',
                'fechaInhuma' => 'required|date',
                'causaMuer' => 'nullable|string',
                'idEspacio' => 'required|exists:espacios,idEspacio',
                'idTipo' => 'required|exists:tipoInhumacion,idTipo'
            ]);

            DB::beginTransaction();

            $inhumacion = Inhumacion::create([
                'nombre' => $request->nombre,
                'paterno' => $request->paterno,
                'materno' => $request->materno,
                'fechaNaci' => $request->fechaNaci,
                'fechaDefun' => $request->fechaDefun,
                'fechaInhuma' => $request->fechaInhuma,
                'causaMuer' => $request->causaMuer,
                'idEspacio' => $request->idEspacio,
                'idTipo' => $request->idTipo
            ]);

            // Actualizar el estado del espacio a ocupado
            $espacio = Espacio::find($request->idEspacio);
            if ($espacio) {
                $espacio->update(['estado' => 'ocupado']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Inhumación registrada exitosamente',
                'data' => $inhumacion
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la inhumación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $inhumacion = Inhumacion::with(['tipo', 'espacio.direccion', 'espacio.dimension', 'espacio.cementerio'])
                ->findOrFail($id);

            $data = [
                'idInhum' => $inhumacion->idInhum,
                'nombre' => $inhumacion->nombre,
                'paterno' => $inhumacion->paterno,
                'materno' => $inhumacion->materno,
                'fechaNaci' => $inhumacion->fechaNaci,
                'fechaDefun' => $inhumacion->fechaDefun,
                'fechaInhuma' => $inhumacion->fechaInhuma,
                'causaMuer' => $inhumacion->causaMuer,
                'idTipo' => $inhumacion->idTipo,
                'idEspacio' => $inhumacion->idEspacio,
                'tipo_nombre' => $inhumacion->tipo->nombre ?? null
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar la inhumación'
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
                'nombre' => 'required|string|max:100',
                'paterno' => 'required|string|max:100',
                'materno' => 'nullable|string|max:100',
                'fechaNaci' => 'nullable|date',
                'fechaDefun' => 'required|date',
                'fechaInhuma' => 'required|date',
                'causaMuer' => 'nullable|string',
                'idEspacio' => 'required|exists:espacios,idEspacio',
                'idTipo' => 'required|exists:tipoInhumacion,idTipo'
            ]);

            $inhumacion = Inhumacion::findOrFail($id);

            // Si cambia de espacio, actualizar estados
            if ($inhumacion->idEspacio != $request->idEspacio) {
                // Liberar el espacio anterior
                $espacioAnterior = Espacio::find($inhumacion->idEspacio);
                if ($espacioAnterior) {
                    $espacioAnterior->update(['estado' => 'disponible']);
                }

                // Ocupar el nuevo espacio
                $espacioNuevo = Espacio::find($request->idEspacio);
                if ($espacioNuevo) {
                    $espacioNuevo->update(['estado' => 'ocupado']);
                }
            }

            DB::beginTransaction();

            $inhumacion->update([
                'nombre' => $request->nombre,
                'paterno' => $request->paterno,
                'materno' => $request->materno,
                'fechaNaci' => $request->fechaNaci,
                'fechaDefun' => $request->fechaDefun,
                'fechaInhuma' => $request->fechaInhuma,
                'causaMuer' => $request->causaMuer,
                'idEspacio' => $request->idEspacio,
                'idTipo' => $request->idTipo
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Inhumación actualizada exitosamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
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
            $inhumacion = Inhumacion::findOrFail($id);

            DB::beginTransaction();

            // Liberar el espacio
            $espacio = Espacio::find($inhumacion->idEspacio);
            if ($espacio) {
                $espacio->update(['estado' => 'disponible']);
            }

            $inhumacion->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Inhumación eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }
}
