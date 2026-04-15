<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesYPermisosSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Creamos los roles (si no existen)
        $rolDirector = Role::firstOrCreate(['name' => 'Director', 'guard_name' => 'web']);
        $rolEncargado = Role::firstOrCreate(['name' => 'Encargado de Convivencia Escolar', 'guard_name' => 'web']);

        // 2. Le damos permisos básicos al Director (Solo mirar)
        $rolDirector->syncPermissions([
            'view_any_incident',
            'view_incident',
            // Agrega aquí si quieres que vea usuarios: 'view_any_user',
        ]);

        // 3. Le damos poderes al Encargado (Crear y editar incidentes)
        $rolEncargado->syncPermissions([
            'view_any_incident',
            'view_incident',
            'create_incident',
            'update_incident',
            // Puedes agregar 'delete_incident' si le das permiso de borrar
        ]);
    }
}