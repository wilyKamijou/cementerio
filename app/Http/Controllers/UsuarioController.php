<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol;
use App\Models\Empleado;
use App\Models\Cliente;
use App\Models\Permiso;
use App\Models\RolPermiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with(['roles', 'empleados', 'clientes'])->get();
        $roles = Rol::all();
        $empleados = Empleado::all();
        $clientes = Cliente::all();
        $permisos = Permiso::all();

        return view('gestionarUsuario.admin-usuarios', compact('usuarios', 'roles', 'empleados', 'clientes', 'permisos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        DB::beginTransaction();
        try {
            // Si se está creando un nuevo rol
            if ($request->filled('nuevo_rol_nombre')) {
                $rol = Rol::create([
                    'nombre' => $request->nuevo_rol_nombre,
                    'descripcion' => $request->nuevo_rol_descripcion ?? 'Rol creado desde usuario'
                ]);

                // Asignar permisos al nuevo rol
                if ($request->has('nuevos_permisos')) {
                    foreach ($request->nuevos_permisos as $idPer) {
                        RolPermiso::create([
                            'idRol' => $rol->idRol,
                            'idPer' => $idPer
                        ]);
                    }
                }

                $idRol = $rol->idRol;
            } else {
                $idRol = $request->idRol;
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'idRol' => $idRol,
                'idEmpleado' => $request->idEmpleado,
                'idCliente' => $request->idCliente,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Usuario creado exitosamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'idRol' => $request->idRol,
            'idEmpleado' => $request->idEmpleado,
            'idCliente' => $request->idCliente,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json(['success' => true, 'message' => 'Usuario actualizado exitosamente']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'Usuario eliminado exitosamente']);
    }

    public function show($id)
    {
        $user = User::with(['roles'])->findOrFail($id);
        return response()->json($user);
    }
}
