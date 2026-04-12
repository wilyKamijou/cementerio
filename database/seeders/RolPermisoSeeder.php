<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\RolPermiso;
use Illuminate\Support\Facades\DB;

class RolPermisoSeeder extends Seeder
{
    public function run()
    {
        // 👇 CORREGIR: usar el nombre correcto de tu tabla
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Rol::truncate();
        Permiso::truncate();
        RolPermiso::truncate();  // ← Esto usa el modelo, no el nombre directo
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Crear roles
        $admin = Rol::create([
            'nombre' => 'Administrador',
            'descripcion' => 'Acceso total al sistema'
        ]);

        $vendedor = Rol::create([
            'nombre' => 'Vendedor',
            'descripcion' => 'Gestión de ventas y contratos'
        ]);

        $cliente = Rol::create([
            'nombre' => 'Cliente',
            'descripcion' => 'Acceso limitado como cliente'
        ]);

        // 2. Crear permisos
        $permisosLista = [
            ['nombre' => 'ver_dashboard', 'ruta' => '/sepulturero/dashboard', 'descripcion' => 'Ver dashboard'],
            ['nombre' => 'ver_contratos', 'ruta' => '/sepulturero/contratos', 'descripcion' => 'Ver contratos'],
            ['nombre' => 'crear_contrato', 'ruta' => '/sepulturero/contratos/create', 'descripcion' => 'Crear contratos'],
            ['nombre' => 'ver_inhumaciones', 'ruta' => '/sepulturero/inhumaciones', 'descripcion' => 'Ver inhumaciones'],
            ['nombre' => 'crear_inhumacion', 'ruta' => '/sepulturero/inhumaciones/create', 'descripcion' => 'Registrar inhumaciones'],
            ['nombre' => 'ver_mantenimiento', 'ruta' => '/sepulturero/mantenimiento', 'descripcion' => 'Ver mantenimientos'],
            ['nombre' => 'ver_ventas', 'ruta' => '/sepulturero/ventas', 'descripcion' => 'Ver ventas'],
            ['nombre' => 'registrar_venta', 'ruta' => '/sepulturero/ventas/create', 'descripcion' => 'Registrar ventas'],
            ['nombre' => 'ver_clientes', 'ruta' => '/sepulturero/clientes', 'descripcion' => 'Ver clientes'],
        ];

        $permisos = [];
        foreach ($permisosLista as $permisoData) {
            $permisos[] = Permiso::create($permisoData);
        }

        // 3. Asignar permisos usando el modelo RolPermiso
        // Administrador: TODOS los permisos
        foreach ($permisos as $permiso) {
            RolPermiso::create([
                'idRol' => $admin->idRol,
                'idPer' => $permiso->idPer
            ]);
        }

        // Vendedor: permisos específicos
        $permisosVendedor = [
            'ver_dashboard',
            'ver_contratos',
            'crear_contrato',
            'ver_inhumaciones',
            'ver_ventas',
            'registrar_venta',
            'ver_clientes'
        ];

        foreach ($permisos as $permiso) {
            if (in_array($permiso->nombre, $permisosVendedor)) {
                RolPermiso::create([
                    'idRol' => $vendedor->idRol,
                    'idPer' => $permiso->idPer
                ]);
            }
        }

        // Cliente: solo ver contratos e inhumaciones
        $permisosCliente = ['ver_contratos', 'ver_inhumaciones'];

        foreach ($permisos as $permiso) {
            if (in_array($permiso->nombre, $permisosCliente)) {
                RolPermiso::create([
                    'idRol' => $cliente->idRol,
                    'idPer' => $permiso->idPer
                ]);
            }
        }

        $this->command->info('✅ Roles y permisos creados exitosamente!');
    }
}
