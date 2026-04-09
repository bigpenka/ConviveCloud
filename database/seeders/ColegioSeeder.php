<?php

namespace Database\Seeders;

use App\Models\School; // 🔥 Aquí usamos el nombre real de tu archivo
use App\Models\User;
use Illuminate\Database\Seeder;

class ColegioSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Creamos los colegios (Tenants) con nombres en español
        $c1 = School::updateOrCreate(
            ['slug' => 'ust-temuco'],
            ['nombre' => 'Santo Tomás Temuco', 'rut_institucion' => '11.111.111-1']
        );

        $c2 = School::updateOrCreate(
            ['slug' => 'liceo-gm'],
            ['nombre' => 'Liceo Gabriela Mistral', 'rut_institucion' => '22.222.222-2']
        );

        // 2. Buscamos a tu usuario Franco para darle acceso
        // ⚠️ REEMPLAZA por el correo que usas para loguearte
        $user = User::where('email', 'admin@convivecloud.cl')->first(); // o el email que usaste

        if ($user) {
            // Vinculamos tu usuario a los dos colegios en la tabla pivote
            // Asegúrate de que en User.php la relación se llame 'schools' o 'colegios'
            $user->schools()->sync([$c1->id, $c2->id]);
        }
    }
}