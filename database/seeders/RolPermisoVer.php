<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Permiso;

class RolPermisoVer extends Seeder
{
    public function run()
    {
        // ========== 1. CREAR PERMISOS BASE (SOLO VER) ==========
        $permisos = [
            // ========== USUARIOS ==========
            ['nombre' => 'ver_usuarios', 'ruta' => '/admin/usuarios', 'descripcion' => 'Ver lista de usuarios'],
            ['nombre' => 'ver_roles_permisos', 'ruta' => '/admin/roles/permisos', 'descripcion' => 'Ver qué permisos tiene un rol'],

            // ========== ROLES ==========
            ['nombre' => 'ver_roles', 'ruta' => '/admin/roles', 'descripcion' => 'Ver lista de roles'],

            // ========== PERMISOS ==========
            ['nombre' => 'ver_permisos', 'ruta' => '/admin/permisos', 'descripcion' => 'Ver lista de permisos'],

            // ========== EMPLEADOS ==========
            ['nombre' => 'ver_empleados', 'ruta' => '/admin/empleados', 'descripcion' => 'Ver lista de empleados'],

            // ========== ESPACIOS ==========
            ['nombre' => 'ver_espacios', 'ruta' => '/admin/espacios', 'descripcion' => 'Ver espacios funerarios'],

            // ========== CEMENTERIOS ==========
            ['nombre' => 'ver_cementerios', 'ruta' => '/admin/cementerios', 'descripcion' => 'Ver cementerios'],

            // ========== DIMENSIONES ==========
            ['nombre' => 'ver_dimensiones', 'ruta' => '/admin/dimensiones', 'descripcion' => 'Ver dimensiones'],

            // ========== DIRECCIONES ==========
            ['nombre' => 'ver_direcciones', 'ruta' => '/admin/direcciones', 'descripcion' => 'Ver direcciones'],

            // ========== CLIENTES ==========
            ['nombre' => 'ver_clientes', 'ruta' => '/admin/clientes', 'descripcion' => 'Ver lista de clientes'],

            // ========== CONTRATOS ==========
            ['nombre' => 'ver_contratos', 'ruta' => '/admin/contratos', 'descripcion' => 'Ver contratos'],

            // ========== PAGOS ==========
            ['nombre' => 'ver_pagos', 'ruta' => '/admin/pagos', 'descripcion' => 'Ver pagos'],

            // ========== INHUMACIONES ==========
            ['nombre' => 'ver_inhumaciones', 'ruta' => '/admin/inhumaciones', 'descripcion' => 'Ver inhumaciones'],

            // ========== TIPOS DE INHUMACIÓN ==========
            ['nombre' => 'ver_tipo_inhumaciones', 'ruta' => '/admin/tipo_inhumaciones', 'descripcion' => 'Ver tipos de inhumación'],

            // ========== MANTENIMIENTOS ==========
            ['nombre' => 'ver_mantenimientos', 'ruta' => '/admin/mantenimientos', 'descripcion' => 'Ver mantenimientos'],

            // ========== REPORTES ==========
            ['nombre' => 'ver_reportes', 'ruta' => '/admin/reportes', 'descripcion' => 'Ver reportes'],

            // ========== COMPROMISOS ==========
            ['nombre' => 'ver_compromisos', 'ruta' => '/admin/compromisos', 'descripcion' => 'Ver compromisos de pago'],
        ];

        foreach ($permisos as $permiso) {
            Permiso::firstOrCreate(
                ['nombre' => $permiso['nombre']],
                $permiso
            );
        }

        // ========== 2. CREAR ROLES BASE ==========
        $admin = Rol::firstOrCreate(
            ['nombre' => 'Administrador', 'descripcion' => 'Acceso total']
        );

        $cajero = Rol::firstOrCreate(
            ['nombre' => 'Cajero', 'descripcion' => 'Gestión de clientes, contratos y pagos']
        );

        $operador = Rol::firstOrCreate(
            ['nombre' => 'Operador', 'descripcion' => 'Registro de inhumaciones y mantenimiento']
        );

        $cliente = Rol::firstOrCreate(
            ['nombre' => 'Cliente', 'descripcion' => 'Consulta de contratos y pagos en línea']
        );

        $consulta = Rol::firstOrCreate(
            ['nombre' => 'Consulta', 'descripcion' => 'Solo lectura del sistema']
        );

        // ========== 3. ASIGNAR PERMISOS A ROLES ==========

        // 👑 ADMINISTRADOR: TODOS los permisos
        $admin->permisos()->sync(Permiso::all()->pluck('idPer'));

        // 💰 CAJERO: permisos de visualización de clientes, contratos, pagos, reportes
        $cajero->permisos()->sync(Permiso::whereIn('nombre', [
            'ver_clientes',
            'ver_contratos',
            'ver_pagos',
            'ver_reportes',
            'ver_compromisos',
        ])->pluck('idPer'));

        // 🔧 OPERADOR: permisos de visualización de inhumaciones, mantenimientos y espacios
        $operador->permisos()->sync(Permiso::whereIn('nombre', [
            'ver_inhumaciones',
            'ver_mantenimientos',
            'ver_espacios',
            'ver_cementerios',
            'ver_dimensiones',
            'ver_direcciones',
            'ver_tipo_inhumaciones',
        ])->pluck('idPer'));

        // 👤 CLIENTE: sin permisos de ver (solo sus cosas públicas)
        $cliente->permisos()->sync([]);

        // 📋 CONSULTA: TODOS los permisos de VER (solo lectura completa)
        $consulta->permisos()->sync(Permiso::all()->pluck('idPer'));

        // ========== 4. CREAR USUARIO ADMINISTRADOR POR DEFECTO ==========
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@sepulturero.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('admin123'),
                'idRol' => $admin->idRol,
            ]
        );

        // ========== 5. MENSAJES DE ÉXITO ==========
        $this->command->info('✅ Permisos de SOLO LECTURA creados exitosamente!');
        $this->command->info('📌 Total de permisos creados: ' . Permiso::count());
        $this->command->info('📌 Total de roles creados: ' . Rol::count());
        $this->command->info('');
        $this->command->info('🔑 Usuario administrador por defecto:');
        $this->command->info('   Email: admin@sepulturero.com');
        $this->command->info('   Contraseña: 1234');
        $this->command->info('');
        $this->command->info('📋 Roles disponibles:');
        $this->command->info('   - Administrador: Acceso total');
        $this->command->info('   - Cajero: Puede VER clientes, contratos, pagos y reportes');
        $this->command->info('   - Operador: Puede VER inhumaciones, mantenimientos y espacios');
        $this->command->info('   - Cliente: Sin permisos de visualización');
        $this->command->info('   - Consulta: Puede VER todo el sistema (solo lectura)');
    }
}
