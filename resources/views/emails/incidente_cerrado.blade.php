<!DOCTYPE html>
<html>
<head>
    <title>Cierre de Incidente - ConviveCloud</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 10px; border: 1px solid #ddd;">
        <h2 style="color: #4f46e5; text-align: center;">Notificación de Término de Proceso</h2>
        
        <p>Estimado/a <strong>{{ $incident->student->nombre_apoderado ?? 'Apoderado/a' }}</strong>,</p>
        
        <p>En su calidad de <strong>{{ $incident->student->parentesco_apoderado ?? 'Tutor' }}</strong>, le informamos que el incidente registrado el <strong>{{ $incident->created_at->format('d/m/Y') }}</strong>, involucrando al estudiante <strong>{{ $incident->student->nombres }} {{ $incident->student->apellidos }}</strong>, ha concluido sus etapas de protocolo.</p>

        <div style="background: #f9fafb; padding: 15px; border-radius: 8px; border-left: 4px solid #4f46e5; margin: 20px 0;">
            <h3 style="margin-top: 0; font-size: 16px;">📌 Bitácora de Etapas Realizadas:</h3>
            <ul style="list-style: none; padding-left: 0;">
                @foreach($incident->etapas as $etapa)
                    <li style="margin-bottom: 8px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                        <strong>{{ $etapa->nombre }}:</strong> 
                        <span style="color: {{ $etapa->realizado ? '#059669' : '#dc2626' }};">
                            {{ $etapa->realizado ? '✅ Realizado' : '❌ No realizado' }}
                        </span>
                        @if($etapa->observaciones)
                            <br><small style="color: #666;"><em>Obs: {{ $etapa->observaciones }}</em></small>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        <p>El caso ha sido marcado como <strong>CERRADO</strong> en nuestro sistema institucional.</p>
        
        <p style="background: #fffbeb; padding: 10px; border: 1px solid #fcd34d; border-radius: 5px; font-size: 14px;">
            ⚠️ <strong>Importante:</strong> Por favor, acérquese a la oficina de Convivencia Escolar para la revisión y firma del acta oficial (Acta N°: {{ str_pad($incident->id, 5, '0', STR_PAD_LEFT) }}).
        </p>
        
        <br>
        <p style="font-size: 12px; color: #777; text-align: center;">
            Atentamente,<br>
            <strong>Equipo de Convivencia Escolar</strong><br>
            Santo Tomás Temuco - Gestionado vía ConviveCloud
        </p>
    </div>
</body>
</html>