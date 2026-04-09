<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear el usuario Admin siempre
        User::updateOrCreate(
            ['email' => 'admin@convivecloud.cl'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin.123456789'), // Cambia esto
            ]
        );

        // 2. Llamar a los otros Seeders
        $this->call([
            ColegioSeeder::class,
            ProtocolAmenazaSeeder::class,
            // Agrega aquí otros seeders que tengas (ej: Roles, Permisos)
        ]);
    }
}