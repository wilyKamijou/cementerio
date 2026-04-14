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
use Illuminate\Validation\ValidationException;

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
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
            ]);

            DB::beginTransaction();

            $idRol = $request->idRol;

            if ($request->filled('nuevo_rol_nombre')) {
                $rol = Rol::create([
                    'nombre' => $request->nuevo_rol_nombre,
                    'descripcion' => $request->nuevo_rol_descripcion ?? 'Rol creado desde usuario'
                ]);

                if ($request->has('nuevos_permisos')) {
                    foreach ($request->nuevos_permisos as $idPer) {
                        RolPermiso::create([
                            'idRol' => $rol->idRol,
                            'idPer' => $idPer
                        ]);
                    }
                }

                $idRol = $rol->idRol;
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'idRol' => $idRol,
                'idEmpleado' => $request->idEmpleado,
                'idCliente' => $request->idCliente,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '✅ Usuario creado exitosamente'
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();

            // 👇 MENSAJES PERSONALIZADOS Y MÁS CLAROS
            $errors = $e->errors();
            $mensajesClaros = [];

            if (isset($errors['email'])) {
                $mensajesClaros[] = '📧 El correo electrónico ya está registrado. Por favor, usa otro.';
            }

            if (isset($errors['name'])) {
                $mensajesClaros[] = '👤 El nombre de usuario es requerido.';
            }

            if (isset($errors['password'])) {
                $mensajesClaros[] = '🔒 La contraseña debe tener al menos 6 caracteres.';
            }

            if (isset($errors['password_confirmation']) || (isset($errors['password']) && str_contains($errors['password'][0] ?? '', 'confirmed'))) {
                $mensajesClaros[] = '🔑 Las contraseñas no coinciden. Verifica que sean iguales.';
            }

            $errorMessage = implode(' | ', $mensajesClaros);

            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => '❌ Error al crear usuario. Intenta de nuevo.'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
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

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado exitosamente'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = User::with(['roles'])->findOrFail($id);
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }
    }
}
