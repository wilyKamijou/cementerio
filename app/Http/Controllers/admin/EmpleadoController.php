<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return response()->json($empleados);
    }

    public function store(Request $request)
    {
        try {
            // 👇 VALIDACIÓN: nombre completo único
            $request->validate([
                'nombre' => 'required|string|max:255',
                'paterno' => 'required|string|max:255',
                'materno' => 'nullable|string|max:255',
                'direccion' => 'nullable|string',
                'telefono' => 'required|string|regex:/^[0-9]{8,15}$/',
            ]);

            // Verificar si ya existe un empleado con el mismo nombre completo
            $nombreCompleto = trim($request->nombre . ' ' . $request->paterno . ' ' . $request->materno);

            $existe = Empleado::where('nombre', $request->nombre)
                ->where('paterno', $request->paterno)
                ->where(function ($query) use ($request) {
                    if ($request->materno) {
                        $query->where('materno', $request->materno);
                    } else {
                        $query->whereNull('materno');
                    }
                })->exists();

            if ($existe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe un empleado con el nombre completo: ' . $nombreCompleto
                ], 422);
            }

            $empleado = Empleado::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Empleado creado exitosamente',
                'empleado' => $empleado
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $mensajesClaros = [];

            if (isset($errors['telefono'])) {
                $mensajesClaros[] = 'El teléfono debe contener entre 8 y 15 dígitos numéricos';
            }
            if (isset($errors['nombre'])) {
                $mensajesClaros[] = 'El nombre es requerido';
            }
            if (isset($errors['paterno'])) {
                $mensajesClaros[] = 'El apellido paterno es requerido';
            }

            $errorMessage = implode(' | ', $mensajesClaros);

            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear empleado. Intenta de nuevo.'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $empleado = Empleado::findOrFail($id);

            $request->validate([
                'nombre' => 'required|string|max:255',
                'paterno' => 'required|string|max:255',
                'materno' => 'nullable|string|max:255',
                'direccion' => 'nullable|string',
                'telefono' => 'required|string|regex:/^[0-9]{8,15}$/',
            ]);

            // 👇 VERIFICAR SI EL NOMBRE COMPLETO YA EXISTE (EXCLUYENDO EL ACTUAL)
            $existe = Empleado::where('nombre', $request->nombre)
                ->where('paterno', $request->paterno)
                ->where(function ($query) use ($request) {
                    if ($request->materno) {
                        $query->where('materno', $request->materno);
                    } else {
                        $query->whereNull('materno');
                    }
                })
                ->where('idEmpleado', '!=', $id)
                ->exists();

            if ($existe) {
                $nombreCompleto = trim($request->nombre . ' ' . $request->paterno . ' ' . $request->materno);
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe otro empleado con el nombre completo: ' . $nombreCompleto
                ], 422);
            }

            $empleado->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Empleado actualizado exitosamente'
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $mensajesClaros = [];

            if (isset($errors['telefono'])) {
                $mensajesClaros[] = 'El teléfono debe contener entre 8 y 15 dígitos numéricos';
            }
            if (isset($errors['nombre'])) {
                $mensajesClaros[] = 'El nombre es requerido';
            }
            if (isset($errors['paterno'])) {
                $mensajesClaros[] = 'El apellido paterno es requerido';
            }

            $errorMessage = implode(' | ', $mensajesClaros);

            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar empleado. Intenta de nuevo.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $empleado = Empleado::findOrFail($id);
            $empleado->delete();

            return response()->json([
                'success' => true,
                'message' => 'Empleado eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar empleado'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $empleado = Empleado::findOrFail($id);
            return response()->json($empleado);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Empleado no encontrado'
            ], 404);
        }
    }
}
