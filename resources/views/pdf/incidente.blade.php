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
        
        .section-title { background-color: #edf2f7; padding: 8px; font-size: 16px; font-weight: bold; border-left: 4px solid #2d3748; margin-top: 20px; margin-bottom: 10px; }
        
        .info-grid { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-grid td { padding: 8px; border: 1px solid #e2e8f0; font-size: 13px; }
        .label { font-weight: bold; background-color: #f8fafc; width: 30%; }

        .checklist-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .checklist-table th { background-color: #2d3748; color: white; padding: 10px; font-size: 12px; text-align: left; }
        .checklist-table td { padding: 8px; border: 1px solid #cbd5e0; font-size: 12px; }
        .status-check { color: #2f855a; font-weight: bold; text-align: center; width: 20%; }

        .descripcion-box { border: 1px solid #e2e8f0; padding: 15px; min-height: 100px; font-size: 13px; background-color: #fff; }
        
        .footer { margin-top: 60px; text-align: center; font-size: 11px; color: #718096; }
        .signatures { margin-top: 50px; width: 100%; }
        .signatures td { text-align: center; width: 50%; padding-top: 40px; }
        
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="header">
        <h2>Ficha de Incidente de Convivencia Escolar</h2>
        <p>Establecimiento Educacional - Plataforma ConviveCloud</p>
        <p><strong>Protocolo bajo Normativa Circular 482</strong></p>
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
    <div class="descripcion-box">
        {{ $incidente->descripcion }}
    </div>

    <div class="section-title">III. REGISTRO DE ACTUACIÓN (DEBIDO PROCESO)</div>
    <p style="font-size: 11px; margin-bottom: 10px;">Las siguientes etapas han sido ejecutadas conforme al Reglamento Interno de Convivencia Escolar (RICE):</p>
    
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
                    <td colspan="2" style="text-align: center; color: #a0aec0;">No se registraron etapas marcadas en el sistema.</td>
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
        <p>Copia fiel del registro digital. La manipulación de este documento sin autorización es sancionada.</p>
    </div>

    <script>
        // Solo ejecutar el print si no estamos en entorno de desarrollo local si prefieres
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>