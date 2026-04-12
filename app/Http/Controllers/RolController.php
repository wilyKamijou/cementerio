<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\RolPermiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre',
            'descripcion' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $rol = Rol::create($request->only('nombre', 'descripcion'));

            if ($request->has('permisos')) {
                foreach ($request->permisos as $idPer) {
                    RolPermiso::create([
                        'idRol' => $rol->idRol,
                        'idPer' => $idPer
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Rol creado exitosamente', 'rol' => $rol]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre,' . $id . ',idRol',
            'descripcion' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $rol->update($request->only('nombre', 'descripcion'));

            // Actualizar permisos
            RolPermiso::where('idRol', $rol->idRol)->delete();
            if ($request->has('permisos')) {
                foreach ($request->permisos as $idPer) {
                    RolPermiso::create([
                        'idRol' => $rol->idRol,
                        'idPer' => $idPer
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Rol actualizado exitosamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();

        return response()->json(['success' => true, 'message' => 'Rol eliminado exitosamente']);
    }

    public function permisos($id)
    {
        $rol = Rol::findOrFail($id);
        $permisosAsignados = $rol->rolPermisos->pluck('idPer')->toArray();
        $todosPermisos = Permiso::all();

        return response()->json([
            'rol' => $rol,
            'permisos_asignados' => $permisosAsignados,
            'todos_permisos' => $todosPermisos
        ]);
    }
}
