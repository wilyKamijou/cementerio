<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Permiso;

class RolPermisoSeeder extends Seeder
{
    public function run()
    {
        // ========== 1. CREAR PERMISOS BASE (FIJOS - EL CLIENTE NO PUEDE MODIFICAR) ==========
        $permisos = [
            // ========== USUARIOS ==========
            ['nombre' => 'ver_usuarios', 'ruta' => '/admin/usuarios', 'descripcion' => 'Ver lista de usuarios'],
            ['nombre' => 'crear_usuario', 'ruta' => '/admin/usuarios/create', 'descripcion' => 'Crear nuevos usuarios'],
            ['nombre' => 'editar_usuario', 'ruta' => '/admin/usuarios/edit', 'descripcion' => 'Editar usuarios existentes'],
            ['nombre' => 'eliminar_usuario', 'ruta' => '/admin/usuarios/delete', 'descripcion' => 'Eliminar usuarios'],
            ['nombre' => 'asignar_rol', 'ruta' => '/admin/usuarios/rol', 'descripcion' => 'Asignar roles a usuarios'],

            // ========== ROLES ==========
            ['nombre' => 'ver_roles', 'ruta' => '/admin/roles', 'descripcion' => 'Ver lista de roles'],
            ['nombre' => 'crear_rol', 'ruta' => '/admin/roles/create', 'descripcion' => 'Crear nuevos roles'],
            ['nombre' => 'editar_rol', 'ruta' => '/admin/roles/edit', 'descripcion' => 'Editar roles existentes'],
            ['nombre' => 'eliminar_rol', 'ruta' => '/admin/roles/delete', 'descripcion' => 'Eliminar roles'],
            ['nombre' => 'asignar-permisos', 'ruta' => '/roles/{id}/permisos', 'descripcion' => 'Asignar permisos a roles'],
            ['nombre' => 'ver_roles_permisos', 'ruta' => '/admin/roles/permisos', 'descripcion' => 'Ver qué permisos tiene un rol'], // ← CAMBIADO

            // ========== CLIENTES ==========
            ['nombre' => 'ver_clientes', 'ruta' => '/admin/clientes', 'descripcion' => 'Ver lista de clientes'],
            ['nombre' => 'crear_cliente', 'ruta' => '/admin/clientes/create', 'descripcion' => 'Crear nuevos clientes'],
            ['nombre' => 'editar_cliente', 'ruta' => '/admin/clientes/edit', 'descripcion' => 'Editar clientes existentes'],
            ['nombre' => 'eliminar_cliente', 'ruta' => '/admin/clientes/delete', 'descripcion' => 'Eliminar clientes'],

            // ========== ESPACIOS ==========
            ['nombre' => 'ver_espacios', 'ruta' => '/admin/espacios', 'descripcion' => 'Ver espacios funerarios'],
            ['nombre' => 'crear_espacio', 'ruta' => '/admin/espacios/create', 'descripcion' => 'Crear espacios funerarios'],
            ['nombre' => 'editar_espacio', 'ruta' => '/admin/espacios/edit', 'descripcion' => 'Editar espacios funerarios'],
            ['nombre' => 'eliminar_espacio', 'ruta' => '/admin/espacios/delete', 'descripcion' => 'Eliminar espacios funerarios'],

            // ========== EMPLEADOS ==========
            ['nombre' => 'ver_empleados', 'ruta' => '/admin/empleados', 'descripcion' => 'Ver lista de empleados'],
            ['nombre' => 'crear_empleado', 'ruta' => '/admin/empleados/create', 'descripcion' => 'Crear empleados'],
            ['nombre' => 'editar_empleado', 'ruta' => '/admin/empleados/edit', 'descripcion' => 'Editar empleados'],
            ['nombre' => 'eliminar_empleado', 'ruta' => '/admin/empleados/delete', 'descripcion' => 'Eliminar empleados'],

            // ========== CONTRATOS ==========
            ['nombre' => 'ver_contratos', 'ruta' => '/admin/contratos', 'descripcion' => 'Ver contratos'],
            ['nombre' => 'crear_contrato', 'ruta' => '/admin/contratos/create', 'descripcion' => 'Crear contratos'],
            ['nombre' => 'editar_contrato', 'ruta' => '/admin/contratos/edit', 'descripcion' => 'Editar contratos'],
            ['nombre' => 'eliminar_contrato', 'ruta' => '/admin/contratos/delete', 'descripcion' => 'Cancelar/eliminar contratos'],

            // ========== PAGOS ==========
            ['nombre' => 'ver_pagos', 'ruta' => '/admin/pagos', 'descripcion' => 'Ver pagos'],
            ['nombre' => 'crear_pago', 'ruta' => '/admin/pagos/create', 'descripcion' => 'Registrar pagos'],
            ['nombre' => 'editar_pago', 'ruta' => '/admin/pagos/edit', 'descripcion' => 'Editar pagos'],
            ['nombre' => 'eliminar_pago', 'ruta' => '/admin/pagos/delete', 'descripcion' => 'Anular pagos'],

            // ========== INHUMACIONES ==========
            ['nombre' => 'ver_inhumaciones', 'ruta' => '/admin/inhumaciones', 'descripcion' => 'Ver inhumaciones'],
            ['nombre' => 'crear_inhumacion', 'ruta' => '/admin/inhumaciones/create', 'descripcion' => 'Registrar inhumaciones'],
            ['nombre' => 'editar_inhumacion', 'ruta' => '/admin/inhumaciones/edit', 'descripcion' => 'Editar inhumaciones'],
            ['nombre' => 'eliminar_inhumacion', 'ruta' => '/admin/inhumaciones/delete', 'descripcion' => 'Eliminar inhumaciones'],

            // ========== MANTENIMIENTO ==========
            ['nombre' => 'ver_mantenimientos', 'ruta' => '/admin/mantenimientos', 'descripcion' => 'Ver mantenimientos'],
            ['nombre' => 'crear_mantenimiento', 'ruta' => '/admin/mantenimientos/create', 'descripcion' => 'Registrar mantenimientos'],

            // ========== REPORTES ==========
            ['nombre' => 'ver_reportes', 'ruta' => '/admin/reportes', 'descripcion' => 'Ver reportes'],
            ['nombre' => 'exportar_reportes', 'ruta' => '/admin/reportes/exportar', 'descripcion' => 'Exportar reportes en PDF'],
            ['nombre' => 'enviar_reportes', 'ruta' => '/admin/reportes/enviar', 'descripcion' => 'Enviar reportes por email'],
        ];

        foreach ($permisos as $permiso) {
            Permiso::firstOrCreate(
                ['nombre' => $permiso['nombre']],
                $permiso
            );
        }

        // ========== 2. CREAR ROLES BASE (EL CLIENTE PUEDE CREAR MÁS) ==========
        $admin = Rol::firstOrCreate(
            ['nombre' => 'Administrador'],
            ['descripcion' => 'Acceso total - Puede crear, editar, eliminar todo']
        );

        $cajero = Rol::firstOrCreate(
            ['nombre' => 'Cajero'],
            ['descripcion' => 'Gestión de clientes, contratos y pagos']
        );

        $operador = Rol::firstOrCreate(
            ['nombre' => 'Operador'],
            ['descripcion' => 'Registro de inhumaciones y mantenimiento']
        );

        $cliente = Rol::firstOrCreate(
            ['nombre' => 'Cliente'],
            ['descripcion' => 'Consulta de contratos y pagos en línea']
        );

        // ========== 3. ASIGNAR PERMISOS A ROLES ==========

        // 👑 ADMINISTRADOR: TODOS los permisos
        $admin->permisos()->sync(Permiso::all()->pluck('idPer'));

        // 💰 CAJERO: permisos de clientes, contratos, pagos
        $cajero->permisos()->sync(Permiso::whereIn('nombre', [
            'ver_clientes',
            'crear_cliente',
            'editar_cliente',
            'ver_contratos',
            'crear_contrato',
            'ver_pagos',
            'crear_pago',
            'ver_reportes'
        ])->pluck('idPer'));

        // 🔧 OPERADOR: permisos de inhumaciones y mantenimiento
        $operador->permisos()->sync(Permiso::whereIn('nombre', [
            'ver_inhumaciones',
            'crear_inhumacion',
            'ver_mantenimientos',
            'crear_mantenimiento'
        ])->pluck('idPer'));

        // 👤 CLIENTE: permisos públicos
        $cliente->permisos()->sync(Permiso::whereIn('nombre', [
            'procesar_pago_online',
            'consultar_contrato'
        ])->pluck('idPer'));

        // ========== 4. CREAR USUARIO ADMINISTRADOR POR DEFECTO ==========
        \App\Models\User::firstOrCreate(
            ['email' => 'wilianxd474@gmail.com'],
            [
                'name' => 'wilian',
                'password' => bcrypt('1234'),
                'idRol' => $admin->idRol,
            ]
        );

        $this->command->info('✅ Permisos y roles base creados exitosamente!');
        $this->command->info('📌 Los permisos son FIJOS (no se pueden crear/editar/eliminar)');
        $this->command->info('📌 El administrador puede CREAR, EDITAR y ELIMINAR roles');
        $this->command->info('📌 ver_roles_permisos permite VER qué permisos tiene un rol (solo lectura)');
        $this->command->info('🔑 Usuario administrador: admin@sepulturero.com / admin123');
    }
}
