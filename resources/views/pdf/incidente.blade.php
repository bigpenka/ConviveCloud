<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Incidente - ConviveCloud</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; margin: 20px; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 3px solid #1a202c; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; color: #1a202c; }
        .header p { margin: 5px 0; font-size: 14px; color: #4a5568; }
        
        .section-title { background-color: #edf2f7; padding: 8px; font-size: 14px; font-weight: bold; border-left: 4px solid #2d3748; margin-top: 15px; margin-bottom: 10px; text-transform: uppercase; }
        
        .info-grid { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .info-grid td { padding: 6px; border: 1px solid #e2e8f0; font-size: 12px; }
        .label { font-weight: bold; background-color: #f8fafc; width: 25%; }

        /* Estilo para las tablas de datos JSON */
        .json-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; background-color: #fff; }
        .json-table td { padding: 8px; border: 1px solid #e2e8f0; font-size: 12px; vertical-align: top; }
        .json-label { font-weight: bold; color: #2d3748; background-color: #f1f5f9; width: 30%; }

        .checklist-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .checklist-table th { background-color: #2d3748; color: white; padding: 8px; font-size: 11px; text-align: left; }
        .checklist-table td { padding: 6px; border: 1px solid #cbd5e0; font-size: 11px; }
        .status-check { color: #2f855a; font-weight: bold; text-align: center; width: 20%; }

        .descripcion-box { border: 1px solid #e2e8f0; padding: 12px; min-height: 60px; font-size: 12px; background-color: #fff; white-space: pre-wrap; }
        
        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #718096; border-top: 1px solid #e2e8f0; padding-top: 10px; }
        .signatures { margin-top: 40px; width: 100%; }
        .signatures td { text-align: center; width: 50%; padding-top: 30px; font-size: 12px; }
        
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="header">
        <h2>Ficha de Incidente de Convivencia Escolar</h2>
        <p>Establecimiento Educacional - Plataforma ConviveCloud</p>
        <p><strong>Protocolo bajo Normativa Circular 482 y RICE</strong></p>
    </div>

    <div class="section-title">I. IDENTIFICACIÓN DEL INCIDENTE</div>
    <table class="info-grid">
        <tr>
            <td class="label">Alumno Involucrado:</td>
            <td>{{ $incidente->student->nombres ?? 'N/A' }} {{ $incidente->student->apellidos ?? '' }}</td>
            <td class="label">RUT:</td>
            <td>{{ $incidente->student->rut ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Fecha del Incidente:</td>
            <td>{{ \Carbon\Carbon::parse($incidente->fecha_incidente)->format('d-m-Y') }}</td>
            <td class="label">Estado del Caso:</td>
            <td><strong>{{ strtoupper($incidente->estado) }}</strong></td>
        </tr>
        <tr>
            <td class="label">Protocolo Aplicado:</td>
            <td colspan="3">{{ $incidente->protocol->nombre ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="section-title">II. DESCRIPCIÓN DE LOS HECHOS</div>
    <div class="descripcion-box">{{ $incidente->descripcion }}</div>

    {{-- 🔥 SECCIÓN DINÁMICA: SEGURO ESCOLAR --}}
    @if(!empty($incidente->seguro_escolar_data))
        <div class="section-title">III. DETALLES DE SEGURO ESCOLAR</div>
        <table class="json-table">
            <tr>
                <td class="json-label">¿Avisado al apoderado?</td>
                <td>{{ ($incidente->seguro_escolar_data['avisado_apoderado'] ?? false) ? 'SÍ' : 'NO' }}</td>
                <td class="json-label">¿Traslado a centro médico?</td>
                <td>{{ ($incidente->seguro_escolar_data['traslado_centro'] ?? false) ? 'SÍ' : 'NO' }}</td>
            </tr>
            <tr>
                <td class="json-label">Lugar de atención:</td>
                <td colspan="3">{{ $incidente->seguro_escolar_data['centro_asistencial'] ?? 'No especificado' }}</td>
            </tr>
            <tr>
                <td class="json-label">Descripción de lesión:</td>
                <td colspan="3">{{ $incidente->seguro_escolar_data['descripcion_lesion'] ?? 'Sin descripción adicional' }}</td>
            </tr>
        </table>
    @endif

    {{-- 🔥 SECCIÓN DINÁMICA: INVESTIGACIÓN --}}
    @if(!empty($incidente->informe_accidente_data))
        <div class="section-title">IV. INFORME DE INVESTIGACIÓN</div>
        <table class="json-table">
            <tr>
                <td class="json-label">Causas del accidente:</td>
                <td colspan="3">{{ $incidente->informe_accidente_data['causas'] ?? 'Sin registro' }}</td>
            </tr>
            <tr>
                <td class="json-label">Medidas preventivas:</td>
                <td colspan="3">{{ $incidente->informe_accidente_data['medidas'] ?? 'Sin registro' }}</td>
            </tr>
            <tr>
                <td class="json-label">Testigos presenciales:</td>
                <td colspan="3">{{ $incidente->informe_accidente_data['testigos'] ?? 'No se registran testigos' }}</td>
            </tr>
        </table>
    @endif

    <div class="section-title">V. REGISTRO DE ACTUACIÓN (DEBIDO PROCESO)</div>
    <table class="checklist-table">
        <thead>
            <tr>
                <th>ETAPA / ACCIÓN EJECUTADA</th>
                <th>ESTADO</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pasosMarcados as $paso)
                <tr>
                    <td>{{ $paso->name }}</td>
                    <td class="status-check">CUMPLIDO</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" style="text-align: center; color: #a0aec0;">No se registraron etapas marcadas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="signatures">
        <tr>
            <td>
                ________________________________<br>
                <strong>Firma Encargado Convivencia</strong><br>
                Timbre Establecimiento
            </td>
            <td>
                ________________________________<br>
                <strong>Firma Apoderado / Alumno</strong><br>
                RUN: __________________
            </td>
        </tr>
    </table>

    <div class="footer">
        <p>Documento generado de forma electrónica por ConviveCloud el {{ now()->format('d/m/Y \a \l\a\s H:i') }} hrs.</p>
        <p>Copia fiel del registro digital. La manipulación de este documento es sancionada bajo el reglamento interno.</p>
    </div>
</body>
</html>