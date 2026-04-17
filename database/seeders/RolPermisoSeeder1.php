<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Permiso;

class RolPermisoSeeder extends Seeder
{
    public function run()
    {
        // ========== 1. CREAR PERMISOS BASE ==========
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
            ['nombre' => 'asignar_permisos', 'ruta' => '/admin/roles/{id}/permisos', 'descripcion' => 'Asignar permisos a roles'],
            ['nombre' => 'ver_roles_permisos', 'ruta' => '/admin/roles/permisos', 'descripcion' => 'Ver qué permisos tiene un rol'],

            // ========== PERMISOS ==========
            ['nombre' => 'ver_permisos', 'ruta' => '/admin/permisos', 'descripcion' => 'Ver lista de permisos'],

            // ========== EMPLEADOS ==========
            ['nombre' => 'ver_empleados', 'ruta' => '/admin/empleados', 'descripcion' => 'Ver lista de empleados'],
            ['nombre' => 'crear_empleado', 'ruta' => '/admin/empleados/create', 'descripcion' => 'Crear empleados'],
            ['nombre' => 'editar_empleado', 'ruta' => '/admin/empleados/edit', 'descripcion' => 'Editar empleados'],
            ['nombre' => 'eliminar_empleado', 'ruta' => '/admin/empleados/delete', 'descripcion' => 'Eliminar empleados'],

            // ========== ESPACIOS ==========
            ['nombre' => 'ver_espacios', 'ruta' => '/admin/espacios', 'descripcion' => 'Ver espacios funerarios'],
            ['nombre' => 'crear_espacio', 'ruta' => '/admin/espacios/create', 'descripcion' => 'Crear espacios funerarios'],
            ['nombre' => 'editar_espacio', 'ruta' => '/admin/espacios/edit', 'descripcion' => 'Editar espacios funerarios'],
            ['nombre' => 'eliminar_espacio', 'ruta' => '/admin/espacios/delete', 'descripcion' => 'Eliminar espacios funerarios'],

            // ========== CEMENTERIOS ==========
            ['nombre' => 'ver_cementerios', 'ruta' => '/admin/cementerios', 'descripcion' => 'Ver cementerios'],
            ['nombre' => 'crear_cementerio', 'ruta' => '/admin/cementerios/create', 'descripcion' => 'Crear cementerios'],
            ['nombre' => 'editar_cementerio', 'ruta' => '/admin/cementerios/edit', 'descripcion' => 'Editar cementerios'],
            ['nombre' => 'eliminar_cementerio', 'ruta' => '/admin/cementerios/delete', 'descripcion' => 'Eliminar cementerios'],

            // ========== DIMENSIONES ==========
            ['nombre' => 'ver_dimensiones', 'ruta' => '/admin/dimensiones', 'descripcion' => 'Ver dimensiones'],
            ['nombre' => 'crear_dimension', 'ruta' => '/admin/dimensiones/create', 'descripcion' => 'Crear dimensiones'],
            ['nombre' => 'editar_dimension', 'ruta' => '/admin/dimensiones/edit', 'descripcion' => 'Editar dimensiones'],
            ['nombre' => 'eliminar_dimension', 'ruta' => '/admin/dimensiones/delete', 'descripcion' => 'Eliminar dimensiones'],

            // ========== DIRECCIONES ==========
            ['nombre' => 'ver_direcciones', 'ruta' => '/admin/direcciones', 'descripcion' => 'Ver direcciones'],
            ['nombre' => 'crear_direccion', 'ruta' => '/admin/direcciones/create', 'descripcion' => 'Crear direcciones'],
            ['nombre' => 'editar_direccion', 'ruta' => '/admin/direcciones/edit', 'descripcion' => 'Editar direcciones'],
            ['nombre' => 'eliminar_direccion', 'ruta' => '/admin/direcciones/delete', 'descripcion' => 'Eliminar direcciones'],

            // ========== CLIENTES ==========
            ['nombre' => 'ver_clientes', 'ruta' => '/admin/clientes', 'descripcion' => 'Ver lista de clientes'],
            ['nombre' => 'crear_cliente', 'ruta' => '/admin/clientes/create', 'descripcion' => 'Crear nuevos clientes'],
            ['nombre' => 'editar_cliente', 'ruta' => '/admin/clientes/edit', 'descripcion' => 'Editar clientes existentes'],
            ['nombre' => 'eliminar_cliente', 'ruta' => '/admin/clientes/delete', 'descripcion' => 'Eliminar clientes'],

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
            ['nombre' => 'procesar_pago_online', 'ruta' => '/pagos/procesar', 'descripcion' => 'Procesar pagos en línea'],

            // ========== INHUMACIONES ==========
            ['nombre' => 'ver_inhumaciones', 'ruta' => '/admin/inhumaciones', 'descripcion' => 'Ver inhumaciones'],
            ['nombre' => 'crear_inhumacion', 'ruta' => '/admin/inhumaciones/create', 'descripcion' => 'Registrar inhumaciones'],
            ['nombre' => 'editar_inhumacion', 'ruta' => '/admin/inhumaciones/edit', 'descripcion' => 'Editar inhumaciones'],
            ['nombre' => 'eliminar_inhumacion', 'ruta' => '/admin/inhumaciones/delete', 'descripcion' => 'Eliminar inhumaciones'],

            // ========== TIPOS DE INHUMACIÓN ==========
            ['nombre' => 'ver_tipo_inhumaciones', 'ruta' => '/admin/tipo_inhumaciones', 'descripcion' => 'Ver tipos de inhumación'],
            ['nombre' => 'crear_tipo_inhumacion', 'ruta' => '/admin/tipo_inhumaciones/create', 'descripcion' => 'Crear tipos de inhumación'],
            ['nombre' => 'editar_tipo_inhumacion', 'ruta' => '/admin/tipo_inhumaciones/edit', 'descripcion' => 'Editar tipos de inhumación'],
            ['nombre' => 'eliminar_tipo_inhumacion', 'ruta' => '/admin/tipo_inhumaciones/delete', 'descripcion' => 'Eliminar tipos de inhumación'],

            // ========== MANTENIMIENTOS ==========
            ['nombre' => 'ver_mantenimientos', 'ruta' => '/admin/mantenimientos', 'descripcion' => 'Ver mantenimientos'],
            ['nombre' => 'crear_mantenimiento', 'ruta' => '/admin/mantenimientos/create', 'descripcion' => 'Registrar mantenimientos'],
            ['nombre' => 'editar_mantenimiento', 'ruta' => '/admin/mantenimientos/edit', 'descripcion' => 'Editar mantenimientos'],
            ['nombre' => 'eliminar_mantenimiento', 'ruta' => '/admin/mantenimientos/delete', 'descripcion' => 'Eliminar mantenimientos'],

            // ========== REPORTES ==========
            ['nombre' => 'ver_reportes', 'ruta' => '/admin/reportes', 'descripcion' => 'Ver reportes'],
            ['nombre' => 'exportar_reportes', 'ruta' => '/admin/reportes/exportar', 'descripcion' => 'Exportar reportes en PDF/Excel'],
            ['nombre' => 'enviar_reportes', 'ruta' => '/admin/reportes/enviar', 'descripcion' => 'Enviar reportes por email'],

            // ========== COMPROMISOS ==========
            ['nombre' => 'ver_compromisos', 'ruta' => '/admin/compromisos', 'descripcion' => 'Ver compromisos de pago'],
            ['nombre' => 'crear_compromiso', 'ruta' => '/admin/compromisos/create', 'descripcion' => 'Crear compromisos de pago'],

            // ========== CONTRATOS PÚBLICOS ==========
            ['nombre' => 'consultar_contrato', 'ruta' => '/contratos/estado/{token}', 'descripcion' => 'Consultar estado de contrato público'],
        ];

        foreach ($permisos as $permiso) {
            Permiso::firstOrCreate(
                ['nombre' => $permiso['nombre']],
                $permiso
            );
        }

        // ========== 2. CREAR ROLES BASE ==========
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

        // 💰 CAJERO: permisos de clientes, contratos, pagos, reportes, compromisos
        $cajero->permisos()->sync(Permiso::whereIn('nombre', [
            'ver_clientes',
            'crear_cliente',
            'editar_cliente',
            'eliminar_cliente',
            'ver_contratos',
            'crear_contrato',
            'editar_contrato',
            'eliminar_contrato',
            'ver_pagos',
            'crear_pago',
            'editar_pago',
            'eliminar_pago',
            'procesar_pago_online',
            'ver_reportes',
            'exportar_reportes',
            'enviar_reportes',
            'ver_compromisos',
            'crear_compromiso',
            'consultar_contrato',
        ])->pluck('idPer'));

        // 🔧 OPERADOR: permisos de inhumaciones, mantenimientos y visualización de espacios
        $operador->permisos()->sync(Permiso::whereIn('nombre', [
            'ver_inhumaciones',
            'crear_inhumacion',
            'editar_inhumacion',
            'eliminar_inhumacion',
            'ver_mantenimientos',
            'crear_mantenimiento',
            'editar_mantenimiento',
            'eliminar_mantenimiento',
            'ver_espacios',
            'ver_cementerios',
            'ver_dimensiones',
            'ver_direcciones',
            'ver_tipo_inhumaciones',
        ])->pluck('idPer'));

        // 👤 CLIENTE: permisos públicos
        $cliente->permisos()->sync(Permiso::whereIn('nombre', [
            'procesar_pago_online',
            'consultar_contrato'
        ])->pluck('idPer'));

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
        $this->command->info('✅ Permisos y roles base creados exitosamente!');
        $this->command->info('📌 Total de permisos creados: ' . Permiso::count());
        $this->command->info('📌 Total de roles creados: ' . Rol::count());
        $this->command->info('');
        $this->command->info('🔑 Usuario administrador por defecto:');
        $this->command->info('   Email: admin@sepulturero.com');
        $this->command->info('   Contraseña: admin123');
        $this->command->info('');
        $this->command->info('📋 Roles disponibles:');
        $this->command->info('   - Administrador: Acceso total');
        $this->command->info('   - Cajero: Gestión de clientes, contratos y pagos');
        $this->command->info('   - Operador: Registro de inhumaciones y mantenimiento');
        $this->command->info('   - Cliente: Consulta de contratos y pagos en línea');
    }
}
