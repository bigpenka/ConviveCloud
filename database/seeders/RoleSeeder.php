<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // Usamos el modelo de Spatie

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Usamos firstOrCreate para que si ya existen, no tire error ni los duplique
        Role::firstOrCreate(['name' => 'Director', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Encargado de Convivencia Escolar', 'guard_name' => 'web']);
    }
}