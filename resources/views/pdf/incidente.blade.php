<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acta de Incidente #{{ $incidente->id }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 13px; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #1e3a8a; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #1e3a8a; font-size: 22px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #666; font-size: 12px; }
        
        .section-title { background-color: #1e3a8a; color: #ffffff; padding: 8px 10px; font-weight: bold; margin-top: 25px; margin-bottom: 10px; font-size: 14px; text-transform: uppercase; }
        
        .table-info { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .table-info th, .table-info td { padding: 8px; border: 1px solid #cbd5e1; text-align: left; }
        .table-info th { background-color: #f1f5f9; width: 30%; font-weight: bold; color: #475569; }
        
        .content-box { border: 1px solid #cbd5e1; padding: 15px; background-color: #f8fafc; min-height: 80px; text-align: justify; margin-bottom: 15px;}
        
        .checklist-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .checklist-table th, .checklist-table td { padding: 8px; border-bottom: 1px solid #e2e8f0; text-align: left; font-size: 12px; vertical-align: top; }
        .badge-yes { color: #16a34a; font-weight: bold; }
        .badge-no { color: #dc2626; font-weight: bold; }

        /* Estilos para los formularios digitales incrustados */
        .form-digital { background-color: #f1f5f9; padding: 10px; border-left: 3px solid #3b82f6; margin-top: 8px; font-size: 11px; }
        .form-digital strong { color: #1e40af; }
        
        .footer { text-align: center; margin-top: 50px; font-size: 11px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 15px; }
        .signatures { width: 100%; margin-top: 60px; text-align: center; }
        .signatures td { padding-top: 40px; border-top: 1px solid #333; width: 45%; }
        .spacer { width: 10%; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Reporte Oficial de Incidente</h1>
        <p>Institución: <strong>{{ $incidente->school->name ?? 'ConviveCloud' }}</strong></p>
        <p>Generado el: {{ now()->format('d/m/Y H:i') }} | Acta N°: {{ str_pad($incidente->id, 5, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div class="section-title">Información General</div>
    <table class="table-info">
        <tr>
            <th>Fecha del Hecho:</th>
            <td>{{ \Carbon\Carbon::parse($incidente->fecha_incidente)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Estudiante Involucrado:</th>
            <td>
                @if($incidente->student)
                    {{ $incidente->student->nombres }} (RUT: {{ $incidente->student->rut }})
                @else
                    Incidente General / Institucional
                @endif
            </td>
        </tr>
        <tr>
            <th>Protocolo Aplicado:</th>
            <td>{{ $incidente->protocol->nombre ?? 'Sin protocolo específico' }}</td>
        </tr>
        <tr>
            <th>Estado del Caso:</th>
            <td style="text-transform: uppercase; font-weight: bold;">{{ $incidente->estado ?? 'Abierto' }}</td>
        </tr>
    </table>

    <div class="section-title">Narrativa de los Hechos</div>
    <div class="content-box">
        {!! nl2br(e($incidente->descripcion)) !!}
    </div>

    <div class="section-title">Progreso y Formularios Digitales</div>
    @if(is_array($incidente->checklist) && count($incidente->checklist) > 0)
        <table class="checklist-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Etapa</th>
                    <th style="width: 15%;">Estado</th>
                    <th style="width: 60%;">Registro / Evidencia Digital</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incidente->checklist as $item)
                    <tr>
                        <td><strong>{{ $item['nombre_etapa'] ?? 'Etapa' }}</strong></td>
                        <td>
                            @if(isset($item['completado']) && $item['completado'])
                                <span class="badge-yes">✓ Realizado</span>
                            @else
                                <span class="badge-no">✗ Pendiente</span>
                            @endif
                        </td>
                        <td>
                            @if(($item['nombre_etapa'] ?? '') === 'Llenado Formulario Seguro Escolar')
                                <div class="form-digital">
                                    <p><strong>Centro Asistencial:</strong> {{ $item['centro_medico'] ?? 'No registrado' }}</p>
                                    <p><strong>Hora del Accidente:</strong> {{ $item['hora_accidente'] ?? 'No registrada' }}</p>
                                    <p><strong>Detalle de Lesión:</strong> {!! nl2br(e($item['tipo_lesion'] ?? 'Sin detalles')) !!}</p>
                                </div>
                            
                            @elseif(($item['nombre_etapa'] ?? '') === 'Entrevista Estudiante')
                                <div class="form-digital">
                                    <p><strong>Relato:</strong> {!! nl2br(e($item['relato_estudiante'] ?? 'No registrado')) !!}</p>
                                    <p><strong>Acuerdos:</strong> {!! nl2br(e($item['acuerdos_entrevista'] ?? 'No registrados')) !!}</p>
                                </div>
                            
                            @else
                                {{ $item['observacion'] ?? 'Sin observaciones.' }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="font-size: 12px; color: #666; font-style: italic;">No hay etapas documentadas para este incidente.</p>
    @endif

    <table class="signatures">
        <tr>
            <td>Firma Encargado de Convivencia</td>
            <td class="spacer"></td>
            <td>Firma Apoderado / Involucrado</td>
        </tr>
    </table>

    <div class="footer">
        Documento digitalizado generado a través de ConviveCloud (Iniciativa Cero Papel).<br>
        Uso exclusivo del equipo de Convivencia Escolar y Dirección.
    </div>

</body>
</html>