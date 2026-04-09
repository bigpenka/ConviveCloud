<?php

namespace Database\Seeders;

use App\Models\Protocol;
use App\Models\ProtocolStep;
use Illuminate\Database\Seeder;

class ProtocolAmenazaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Creamos el Protocolo Maestro (Usando los campos que ya arreglamos)
        $protocol = Protocol::updateOrCreate(
            ['nombre' => 'Respuesta ante Amenaza de Violencia Armada'],
            [
                'descripcion' => 'Procedimiento de emergencia ante amenazas externas, disparos o ingreso de armas (Circular 482).',
                'gravedad' => 'Alta',
                'plazo_dias' => 5
            ]
        );

        // 2. Definimos solo los nombres de los pasos legales
        $pasos = [
            'Activación de Alerta y Confinamiento',
            'Denuncia Inmediata a Carabineros',
            'Comunicación Oficial a Comunidad',
            'Resguardo de Evidencia Digital',
            'Denuncia en Superintendencia',
        ];

        // 3. Insertamos los pasos vinculados (Sin usar el campo 'description')
        foreach ($pasos as $nombrePaso) {
            ProtocolStep::updateOrCreate(
                [
                    'protocol_id' => $protocol->id,
                    'name' => $nombrePaso
                ]
            );
        }
    }
}