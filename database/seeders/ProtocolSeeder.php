<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Protocol;
use App\Models\ProtocolStep;

class ProtocolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $protocolos = [
            [
                'nombre' => 'Maltrato Escolar (Bullying/Agresiones)',
                'descripcion' => 'Protocolo ante violencia física, psicológica o ciberacoso entre miembros de la comunidad.',
                'pasos' => ['Detección y Reporte', 'Medidas de Resguardo Inmediatas', 'Comunicación a Apoderados', 'Investigación y Descargos', 'Resolución y Sanción (RICE)', 'Seguimiento Psicosocial']
            ],
            [
                'nombre' => 'Agresiones Sexuales',
                'descripcion' => 'Protocolo de tolerancia cero ante presuntos delitos de carácter sexual.',
                'pasos' => ['Acogida y Protección Víctima', 'Denuncia Obligatoria (Máx 24h)', 'Notificación a Familias', 'Medidas Administrativas de Resguardo', 'Derivación a Redes de Salud/Legal']
            ],
            [
                'nombre' => 'Drogas y Alcohol',
                'descripcion' => 'Procedimiento ante consumo, porte o tráfico de sustancias ilícitas.',
                'pasos' => ['Detección y Resguardo del Alumno', 'Incautación Segura de Sustancia', 'Comunicación a Apoderados', 'Denuncia (si aplica tráfico)', 'Derivación a Programas de Rehabilitación (SENDA)']
            ],
            [
                'nombre' => 'Retención Escolar (Embarazo/Paternidad)',
                'descripcion' => 'Garantizar el derecho a la educación de madres, padres y embarazadas.',
                'pasos' => ['Acompañamiento e Información', 'Plan de Apoyo Pedagógico Flexible', 'Facilidades de Asistencia y Controles Médicos', 'Resguardo de la Matrícula']
            ],
            [
                'nombre' => 'Identidad de Género (Circular 0768)',
                'descripcion' => 'Reconocimiento y apoyo a estudiantes trans y de género no binario.',
                'pasos' => ['Entrevista de Acogida', 'Acuerdo de Uso de Nombre Social', 'Medidas de Apoyo en Infraestructura (Baños)', 'Sensibilización a la Comunidad']
            ],
            [
                'nombre' => 'Discriminación Arbitraria (Ley Zamudio)',
                'descripcion' => 'Acciones ante actos de exclusión por raza, religión, discapacidad u orientación.',
                'pasos' => ['Denuncia del Hecho', 'Cese Inmediato de Acto Discriminatorio', 'Medidas Reparatorias y Educativas', 'Sanción según RICE']
            ],
            [
                'nombre' => 'Conductas Suicidas (Ideación/Intento)',
                'descripcion' => 'Intervención en crisis ante riesgo de vida del estudiante.',
                'pasos' => ['Detección de Señales de Alerta', 'Contención Psicosocial Inmediata', 'Entrega a Adulto Responsable', 'Derivación Urgente a Red de Salud', 'Plan de Reingreso y Monitoreo']
            ],
            [
                'nombre' => 'Accidentes Escolares',
                'descripcion' => 'Procedimiento técnico ante lesiones físicas fortuitas.',
                'pasos' => ['Primeros Auxilios', 'Evaluación de Gravedad y Traslado', 'Llenado de Formulario Seguro Escolar', 'Informe de Investigación de Accidente']
            ],
            [
                'nombre' => 'Vulneración de Derechos (VIF/Abuso Externo)',
                'descripcion' => 'Rol del colegio como garante ante abusos fuera del establecimiento.',
                'pasos' => ['Detección de Indicadores', 'Entrevista Reservada (Dupla)', 'Denuncia a Fiscalía o Tribunal de Familia', 'Acompañamiento Escolar']
            ],
            [
                'nombre' => 'Porte de Armas u Objetos Peligrosos',
                'descripcion' => 'Seguridad comunitaria ante elementos que atentan contra la vida.',
                'pasos' => ['Aislamiento y Resguardo Seguros', 'Denuncia Inmediata (Carabineros)', 'Notificación a Apoderados', 'Aplicación Aula Segura (Expulsión/Cancelación)']
            ],
            [
                'nombre' => 'Salidas Pedagógicas y Giras',
                'descripcion' => 'Protocolo de seguridad en actividades fuera del colegio.',
                'pasos' => ['Planificación y Autorizaciones', 'Nómina y Seguros de Viaje', 'Medidas de Seguridad en Ruta', 'Evaluación Post-Salida']
            ],
            [
                'nombre' => 'Desastres Naturales y Emergencias',
                'descripcion' => 'Plan integral de seguridad escolar (PISE).',
                'pasos' => ['Activación de Alarma', 'Evacuación a Zona de Seguridad', 'Pase de Lista y Control de Alumnos', 'Reincorporación o Retiro por Apoderados']
            ],
            [
                'nombre' => 'Maltrato Adulto a Estudiante',
                'descripcion' => 'Procedimiento ante abusos de funcionarios hacia alumnos.',
                'pasos' => ['Denuncia en Dirección', 'Separación Preventiva del Cargo', 'Denuncia Penal (si hay delito)', 'Sumario Administrativo Interno']
            ],
            [
                'nombre' => 'Maltrato Estudiante a Adulto',
                'descripcion' => 'Protección de los funcionarios ante agresiones de alumnos.',
                'pasos' => ['Resguardo del Funcionario', 'Investigación de los Hechos', 'Sanción Disciplinaria (RICE)', 'Medidas de Reparación']
            ],
        ];

        foreach ($protocolos as $p) {
            $proto = Protocol::create([
                'nombre' => $p['nombre'],
                'descripcion' => $p['descripcion'],
                'gravedad' => 'Leve', 
                'plazo_dias' => 15, // Añadimos el plazo legal estándar para evitar el error
            ]);

            foreach ($p['pasos'] as $index => $nombrePaso) {
                ProtocolStep::create([
                    'protocol_id' => $proto->id,
                    'name' => $nombrePaso,
                    'order' => $index + 1,
                    'is_mandatory' => true
                ]);
            }
        }
    }
}