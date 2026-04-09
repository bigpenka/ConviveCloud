<?php

namespace Database\Seeders;

use App\Models\Protocol;
use App\Models\ProtocolStep;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProtocolSeeder extends Seeder
{
    public function run(): void
    {
        // Limpieza total de protocolos y pasos para que no haya duplicados ni errores
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProtocolStep::truncate();
        Protocol::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            [
                'nombre' => 'Maltrato Escolar (Bullying/Agresiones)',
                'gravedad' => 'Grave', 'plazo' => 5,
                'pasos' => ['Detección y reporte', 'Medidas de resguardo inmediatas', 'Entrevistas de investigación', 'Aplicación de medidas formativas', 'Seguimiento y cierre']
            ],
            [
                'nombre' => 'Agresiones Sexuales y Hechos de Carácter Sexual',
                'gravedad' => 'Gravísima', 'plazo' => 1,
                'pasos' => ['Acogida y protección', 'Denuncia obligatoria (24 hrs)', 'Informe a apoderados', 'Derivación a red de salud', 'Medidas de resguardo escolar']
            ],
            [
                'nombre' => 'Conductas Suicidas y Autolesiones',
                'gravedad' => 'Gravísima', 'plazo' => 1,
                'pasos' => ['Detección y contención', 'Entrevista con apoderado (Vigilancia)', 'Derivación de urgencia', 'Protocolo de reingreso']
            ],
            [
                'nombre' => 'Consumo o Tráfico de Drogas y Alcohol',
                'gravedad' => 'Grave', 'plazo' => 1,
                'pasos' => ['Detección y resguardo', 'Entrevista apoderado', 'Denuncia (si hay tráfico)', 'Derivación SENDA']
            ],
            [
                'nombre' => 'Porte de Armas u Objetos Peligrosos',
                'gravedad' => 'Gravísima', 'plazo' => 1,
                'pasos' => ['Aislamiento y resguardo comunidad', 'Llamado a Carabineros (133)', 'Retiro de objeto por autoridad', 'Medida disciplinaria inmediata']
            ],
            [
                'nombre' => 'Vulneración de Derechos (VIF o Abuso Externo)',
                'gravedad' => 'Gravísima', 'plazo' => 2,
                'pasos' => ['Detección (observación)', 'Entrevista reservada', 'Denuncia Tribunal Familia', 'Seguimiento red externa']
            ],
            [
                'nombre' => 'Accidentes Escolares',
                'gravedad' => 'Mediana', 'plazo' => 1,
                'pasos' => ['Primeros Auxilios', 'Llenado Formulario Seguro Escolar', 'Traslado médico', 'Registro en bitácora']
            ],
            [
                'nombre' => 'Identidad de Género (Circular 0768)',
                'gravedad' => 'Grave', 'plazo' => 5,
                'pasos' => ['Entrevista acuerdo nombre social', 'Adecuación vestimenta y baños', 'Sensibilización comunidad educativa']
            ],
            [
                'nombre' => 'Discriminación Arbitraria (Ley Zamudio)',
                'gravedad' => 'Grave', 'plazo' => 5,
                'pasos' => ['Recepción denuncia', 'Cese de discriminación', 'Entrevistas conciliación', 'Acciones reparación']
            ],
            [
                'nombre' => 'Retención Escolar (Embarazo y Paternidad)',
                'gravedad' => 'Leve', 'plazo' => 10,
                'pasos' => ['Apoyo pedagógico', 'Flexibilidad asistencia', 'Vínculo centro salud', 'Protección no discriminación']
            ],
            [
                'nombre' => 'Desastres Naturales y Emergencias (PISE)',
                'gravedad' => 'Grave', 'plazo' => 1,
                'pasos' => ['Evacuación según plan', 'Corte suministros', 'Comunicación familias', 'Evaluación daños']
            ],
            [
                'nombre' => 'Salidas Pedagógicas y Giras',
                'gravedad' => 'Leve', 'plazo' => 15,
                'pasos' => ['Autorización apoderados', 'Nómina y seguros', 'Revisión técnica transporte', 'Itinerario']
            ],
            [
                'nombre' => 'Maltrato de Adultos a Estudiantes',
                'gravedad' => 'Gravísima', 'plazo' => 1,
                'pasos' => ['Apartar al adulto', 'Denuncia penal', 'Sumario administrativo', 'Apoyo psicológico víctima']
            ],
            [
                'nombre' => 'Fallecimiento de Miembro de la Comunidad',
                'gravedad' => 'Grave', 'plazo' => 1,
                'pasos' => ['Comunicación oficial', 'Duelo institucional', 'Apoyo compañeros', 'Gestión administrativa']
            ],
            [
                'nombre' => 'Movilizaciones y Toma de Local',
                'gravedad' => 'Mediana', 'plazo' => 3,
                'pasos' => ['Diálogo directiva', 'Resguardo infraestructura', 'Protocolo entrega local', 'Recuperación clases']
            ],
        ];

        foreach ($data as $item) {
            $p = Protocol::create([
                'nombre' => $item['nombre'],
                'gravedad' => $item['gravedad'],
                'plazo_dias' => $item['plazo']
            ]);

            foreach ($item['pasos'] as $paso) {
                ProtocolStep::create([
                    'protocol_id' => $p->id,
                    'name' => $paso
                ]);
            }
        }
    }
}