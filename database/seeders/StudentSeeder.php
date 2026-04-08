<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::create([
            'nombres' => 'Juanito',
            'apellidos' => 'Pérez Tapia',
            'rut' => '20.123.456-7',
            'curso' => '8vo Básico A',
        ]);

        Student::create([
            'nombres' => 'María Paz',
            'apellidos' => 'González Jara',
            'rut' => '21.987.654-3',
            'curso' => '1ro Medio B',
        ]);
    }
}