<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // Crear roles con guard_name
            $superAdmin = Role::firstOrCreate(['name' => 'SuperAdministrador', 'guard_name' => 'web']);
            $admin = Role::firstOrCreate(['name' => 'Administrador', 'guard_name' => 'web']);
            $coordinador = Role::firstOrCreate(['name' => 'Coordinador', 'guard_name' => 'web']);
            $usuario = Role::firstOrCreate(['name' => 'Usuario', 'guard_name' => 'web']);

            // Definir permisos
            $permissions = [
                'ver organizaciones', 'crear organizaciones', 'editar organizaciones', 'eliminar organizaciones',
                'ver tipos de reunión', 'crear tipos de reunión', 'editar tipos de reunión', 'eliminar tipos de reunión',
                'ver reuniones', 'crear reuniones', 'editar reuniones', 'eliminar reuniones',
                'ver usuarios', 'crear usuarios', 'editar usuarios', 'eliminar usuarios', 'asignar roles',
                'ver asistencias', 'registrar asistencia', 'modificar asistencia', 'eliminar asistencia',
                'ver reportes', 'generar reportes', 'exportar reportes'
            ];

            // Crear permisos con guard_name
            foreach ($permissions as $permiso) {
                Permission::firstOrCreate(['name' => $permiso, 'guard_name' => 'web']);
            }

            // Asignar permisos a los roles
            $superAdmin->syncPermissions(Permission::all());
            $admin->syncPermissions(Permission::whereIn('name', [
                'ver organizaciones', 'crear organizaciones', 'editar organizaciones',
                'ver tipos de reunión', 'crear tipos de reunión', 'editar tipos de reunión',
                'ver reuniones', 'crear reuniones', 'editar reuniones',
                'ver usuarios', 'crear usuarios', 'editar usuarios',
                'asignar roles',
                'ver asistencias', 'registrar asistencia',
                'ver reportes', 'generar reportes'
            ])->get());

            $coordinador->syncPermissions(Permission::whereIn('name', [
                'ver organizaciones',
                'ver tipos de reunión',
                'ver reuniones', 'crear reuniones', 'editar reuniones',
                'ver usuarios',
                'ver asistencias', 'registrar asistencia',
                'ver reportes'
            ])->get());

            $usuario->syncPermissions(Permission::whereIn('name', [
                'ver reuniones',
                'registrar asistencia'
            ])->get());
        });
    }
}
