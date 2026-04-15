<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\RolPermiso;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::with('permisos')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255|unique:roles,nombre',
                'descripcion' => 'nullable|string'
            ]);

            $rol = Rol::create($request->only('nombre', 'descripcion'));

            // Asignar permisos seleccionados
            if ($request->has('permisos')) {
                foreach ($request->permisos as $idPer) {
                    RolPermiso::create([
                        'idRol' => $rol->idRol,
                        'idPer' => $idPer
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Rol creado exitosamente',
                'rol' => $rol
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $mensajesClaros = [];

            if (isset($errors['nombre'])) {
                $mensajesClaros[] = 'El nombre del rol ya existe. Por favor, usa otro.';
            }

            $errorMessage = implode(' | ', $mensajesClaros);

            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear rol. Intenta de nuevo.'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $rol = Rol::findOrFail($id);

            // Validar
            $request->validate([
                'nombre' => 'required|string|max:255|unique:roles,nombre,' . $id . ',idRol',
                'descripcion' => 'nullable|string'
            ]);

            // Actualizar datos del rol
            $rol->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion
            ]);

            // Sincronizar permisos (elimina los que no están y agrega los nuevos)
            $permisos = $request->permisos ?? [];
            $rol->permisos()->sync($permisos);

            return response()->json([
                'success' => true,
                'message' => 'Rol y permisos actualizados exitosamente'
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $mensaje = isset($errors['nombre']) ? 'El nombre del rol ya existe' : 'Error de validación';
            return response()->json([
                'success' => false,
                'message' => $mensaje
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar rol: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $rol = Rol::findOrFail($id);

            // Verificar si hay usuarios con este rol
            if ($rol->usuarios()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el rol porque tiene usuarios asociados.'
                ], 422);
            }

            $rol->delete();

            return response()->json([
                'success' => true,
                'message' => 'Rol eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar rol'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $rol = Rol::with('permisos')->findOrFail($id);
            return response()->json($rol);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Rol no encontrado'
            ], 404);
        }
    }
    public function permisos($id)
    {
        try {
            $rol = Rol::findOrFail($id);

            // 👇 ESPECIFICA LA TABLA PARA EVITAR AMBIGÜEDAD
            $permisosAsignados = $rol->permisos()->select('permisos.idPer')->pluck('idPer')->toArray();
            $todosPermisos = Permiso::all();

            return response()->json([
                'rol' => $rol,
                'permisos_asignados' => $permisosAsignados,
                'todos_permisos' => $todosPermisos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los datos del rol: ' . $e->getMessage()
            ], 500);
        }
    }
    // Asignar permisos al rol
    public function asignarPermisos(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);
        $rol->permisos()->sync($request->permisos);

        return response()->json([
            'success' => true,
            'message' => 'Permisos actualizados exitosamente'
        ]);
    }
}
