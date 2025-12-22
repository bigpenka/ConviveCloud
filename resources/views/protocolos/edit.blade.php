@extends('layouts.app')

@php
    use Carbon\Carbon;

    $fechaAct = $protocolo->fecha_activacion
        ? (Carbon::parse($protocolo->fecha_activacion)->format('Y-m-d\TH:i'))
        : '';
    $fechaCierre = $protocolo->fecha_cierre
        ? (Carbon::parse($protocolo->fecha_cierre)->format('Y-m-d\TH:i'))
        : '';

    $obs = $protocolo->observacion_cierre ?? '';
    $obsLower = strtolower($obs);
    $done = [
        1 => !empty($protocolo->fecha_activacion),
        2 => (bool) ($protocolo->entrevista_realizada ?? false),
        3 => (bool) ($protocolo->denuncia_policia ?? false)
             || (bool) ($protocolo->denuncia_fiscalia ?? false)
             || (bool) ($protocolo->denuncia_tribunal ?? false)
             || str_contains($obsLower, 'sanci'),
        4 => str_contains($obsLower, 'reuni') && str_contains($obsLower, 'agresor'),
        5 => str_contains($obsLower, 'plan:'),
        6 => !empty($protocolo->fecha_cierre) || str_contains($obsLower, 'informe cierre'),
        7 => ($protocolo->estado ?? '') === 'Cerrado',
    ];
@endphp

@section('content')
<style>
    .etapa-card { border:1px solid #1f2937; border-radius:10px; padding:12px 14px; margin-bottom:8px; background:#0f172a; color:#e5e7eb; display:flex; justify-content:space-between; align-items:center; transition:.2s ease; }
    .etapa-card:hover { border-color:#3b82f6; transform:translateY(-1px); }
    .etapa-done { background:linear-gradient(90deg, rgba(34,197,94,.18), rgba(34,197,94,.08)); border-color:rgba(34,197,94,.6); }
    .etapa-label { margin:0; font-weight:700; }
    .etapa-desc { margin:0; font-size:12px; color:#9ca3af; }
    .btn-ghost { background:transparent; border:1px solid #374151; color:#e5e7eb; border-radius:8px; padding:6px 12px; }
    .btn-ghost:hover { border-color:#3b82f6; color:#3b82f6; }
    .left-card { background:#0b1220; border:1px solid #1f2937; border-radius:12px; padding:16px; color:#e5e7eb; }
    .muted { color:#9ca3af; }
    .alert-soft { border-radius:10px; padding:12px 14px; border:1px solid rgba(249,115,22,.35); background:rgba(249,115,22,.08); color:#e5e7eb; }
</style>

<div class="container-fluid" style="padding-top:10px; padding-bottom:20px;">
    {{-- Alerta preliminar --}}
    @if($protocolo->estado === 'Activo' && empty($protocolo->fecha_activacion))
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert-soft">
                    <i class="fa fa-exclamation-triangle" style="color:#f97316; margin-right:8px;"></i>
                    Protocolo en fase preliminar, estado actual: no activado.
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        {{-- Panel izquierdo: estado y resumen --}}
        <div class="col-md-4 mb-3">
            <div class="left-card mb-3">
                <div class="section-label" style="text-transform:uppercase; letter-spacing:.08em; color:#9ca3af;">Estado del Protocolo</div>
                <h4 style="margin:0 0 8px 0; color:#e5e7eb;">
                    <i class="fa fa-info-circle"></i>
                    Estado Actual: <span class="badge" style="background:#2563eb;">{{ $protocolo->estado }}</span>
                </h4>
            </div>

            <div class="left-card">
                <div class="section-label" style="text-transform:uppercase; letter-spacing:.08em; color:#9ca3af;">Resumen</div>
                <p class="muted" style="margin:0;"><strong>Folio:</strong> {{ $protocolo->folio ?? 'â€”' }}</p>
                <p class="muted" style="margin:0;"><strong>Tipo:</strong> {{ $protocolo->tipo ?? 'â€”' }}</p>
                <p class="muted" style="margin:0;"><strong>Estudiante:</strong> {{ $protocolo->estudiante->nombre ?? 'â€”' }}</p>
                <p class="muted" style="margin:0;"><strong>ActivaciÃ³n:</strong> {{ $protocolo->fecha_activacion ?? 'Pendiente' }}</p>
                <p class="muted" style="margin:0;"><strong>Cierre:</strong> {{ $protocolo->fecha_cierre ?? 'Pendiente' }}</p>
                <p class="muted" style="margin:0;"><strong>Obs. Cierre:</strong> {{ $protocolo->observacion_cierre ?? 'â€”' }}</p>
            </div>
        </div>

        {{-- Panel derecho: etapas y modales --}}
        <div class="col-md-8 mb-3">
            <div class="left-card">
                <div class="section-label" style="text-transform:uppercase; letter-spacing:.08em; color:#9ca3af;">
                    <i class="fa fa-check-square-o"></i> Etapas del protocolo
                </div>

                {{-- Etapa 1 --}}
                <div class="etapa-card {{ $done[1] ? 'etapa-done' : '' }}">
                    <div>
                        <p class="etapa-label">Etapa 1 - Activación</p>
                        <p class="etapa-desc">Pasar a En Ejecución y fijar inicio.</p>
                    </div>
                    <button class="btn-ghost" data-toggle="modal" data-target="#modal-etapa1">Gestionar</button>
                </div>

                {{-- Etapa 2 --}}
                <div class="etapa-card {{ $done[2] ? 'etapa-done' : '' }}">
                    <div>
                        <p class="etapa-label">Etapa 2 - Detalle de hechos y entrevista</p>
                        <p class="etapa-desc">Fecha/hora del hecho, relato y adjunto opcional.</p>
                    </div>
                    <button class="btn-ghost" data-toggle="modal" data-target="#modal-etapa2">Gestionar</button>
                </div>

                {{-- Etapa 3 --}}
                <div class="etapa-card {{ $done[3] ? 'etapa-done' : '' }}">
                    <div>
                        <p class="etapa-label">Etapa 3 - Clasificación (¿es delito?)</p>
                        <p class="etapa-desc">Si es delito: denuncia inmediata. Si no, sanción.</p>
                    </div>
                    <button class="btn-ghost" data-toggle="modal" data-target="#modal-etapa3">Gestionar</button>
                </div>

                {{-- Etapa 4 --}}
                <div class="etapa-card {{ $done[4] ? 'etapa-done' : '' }}">
                    <div>
                        <p class="etapa-label">Etapa 4 - Entrevistas apoderados</p>
                        <p class="etapa-desc">Agendar reuniones ví­ctima/agresor.</p>
                    </div>
                    <button class="btn-ghost" data-toggle="modal" data-target="#modal-etapa4">Gestionar</button>
                </div>

                {{-- Etapa 5 --}}
                <div class="etapa-card {{ $done[5] ? 'etapa-done' : '' }}">
                    <div>
                        <p class="etapa-label">Etapa 5 - Seguimiento</p>
                        <p class="etapa-desc">Plan de apoyo, psicólogo y adjuntos.</p>
                    </div>
                    <button class="btn-ghost" data-toggle="modal" data-target="#modal-etapa5">Gestionar</button>
                </div>

{{-- Etapa 6 --}}
                <div class="etapa-card {{ $done[6] ? 'etapa-done' : '' }}">
                    <div>
                        <p class="etapa-label">Etapa 6 - Informe de cierre</p>
                        <p class="etapa-desc">Subir informe de cierre.</p>
                    </div>
                    <button class="btn-ghost" data-toggle="modal" data-target="#modal-etapa6">Gestionar</button>
                </div>

                {{-- Etapa 7 --}}
                <div class="etapa-card {{ $done[7] ? 'etapa-done' : '' }}">
                    <div>
                        <p class="etapa-label">Etapa 7 - Cierre del protocolo</p>
                        <p class="etapa-desc">Detalle final y cierre.</p>
                    </div>
                    <button class="btn-ghost" data-toggle="modal" data-target="#modal-etapa7">Gestionar</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modales por etapa --}}
{{-- Etapa 1 --}}
<div class="modal fade" id="modal-etapa1" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:#0f172a; color:#e5e7eb;">
      <form method="POST" action="{{ url('protocolos/'.$protocolo->id) }}">
        @csrf @method('PUT')
        <input type="hidden" name="etapa" value="1">
        <div class="modal-header">
          <h4 class="modal-title">Etapa 1: Activación</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Estado</label>
                <select name="estado" class="form-control">
                    <option value="En Ejecucion" {{ $protocolo->estado === 'En Ejecucion' ? 'selected' : '' }}>En Ejecución</option>
                    <option value="Activo" {{ $protocolo->estado === 'Activo' ? 'selected' : '' }}>Activo</option>
                </select>
            </div>
            <div class="form-group">
                <label>Fecha/Hora inicio ejecuciÃ³n</label>
                <input type="datetime-local" name="fecha_activacion" class="form-control" value="{{ $fechaAct }}">
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Guardar etapa 1</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Etapa 2 --}}
<div class="modal fade" id="modal-etapa2" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="background:#0f172a; color:#e5e7eb;">
      <form method="POST" action="{{ url('protocolos/'.$protocolo->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <input type="hidden" name="etapa" value="2">
        <div class="modal-header">
          <h4 class="modal-title">Etapa 2: Detalle de hechos y entrevista</h4>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <label>Fecha del hecho</label>
                <input type="date" name="fec_ev" class="form-control">
              </div>
              <div class="col-md-6">
                <label>Hora del hecho</label>
                <input type="time" name="hora_ev" class="form-control">
              </div>
            </div>
            <div class="form-group mt-2">
                <label>Relato / Resumen de hechos</label>
                <textarea name="relato" class="form-control" rows="4" style="text-transform:uppercase;"></textarea>
            </div>
            <div class="form-group">
                <label>Archivo (foto, video, testigo) - opcional</label>
                <input type="file" name="adjunto_hecho" class="form-control">
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox" name="entrevista_realizada" value="1" {{ $protocolo->entrevista_realizada ? 'checked' : '' }}> Entrevista realizada</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Guardar etapa 2</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Etapa 3 --}}
<div class="modal fade" id="modal-etapa3" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:#0f172a; color:#e5e7eb;">
      <form method="POST" action="{{ url('protocolos/'.$protocolo->id) }}">
        @csrf @method('PUT')
        <input type="hidden" name="etapa" value="3">
        <div class="modal-header">
          <h4 class="modal-title">Etapa 3: ClasificaciÃ³n (Â¿es delito?)</h4>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>¿Es delito?</label>
                <select name="et3_delito" class="form-control" id="sel-delito-3">
                    <option value="no">No</option>
                    <option value="si">Sí</option>
                </select>
                <small class="muted">Si es delito: denuncia inmediata a Carabineros / Fiscalía.</small>
            </div>

            <div id="bloque-sancion" style="display:none;">
                <div class="form-group">
                    <label>Sanción propuesta</label>
                    <select name="et3_sancion" class="form-control">
                        <option value="">Seleccione...</option>
                        <option value="Amonestación escrita">Amonestación escrita</option>
                        <option value="Suspensión 1 día">Suspensión 1 día</option>
                        <option value="Suspensión 3 días">Suspensión 3 días</option>
                        <option value="Suspensión 1 semana">Suspensión 1 semana</option>
                        <option value="Expulsión">Expulsión</option>
                        <option value="Plan reparador / mediación">Plan reparador / mediación</option>
                        <option value="Derivación a apoyo psicosocial">Derivación a apoyo psicosocial</option>
                        <option value="Advertencia formal a apoderados">Advertencia formal a apoderados</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>días de Sanción</label>
                    <select name="et3_dias" class="form-control">
                        <option value="">Seleccione...</option>
                        <option value="1">1 día</option>
                        <option value="3">3 días</option>
                        <option value="5">5 días</option>
                        <option value="7">1 semana</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Detalle / motivo</label>
                    <textarea name="et3_motivo" class="form-control" rows="3" style="text-transform:uppercase;"></textarea>
                </div>
            </div>

            <div class="form-group">
                {{-- Siempre policÃ­a --}}
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="denuncia_policia" value="1"
                               {{ !empty($protocolo->denuncia_policia) ? 'checked' : '' }}>
                        Denuncia a PolicÃ­a
                    </label>
                </div>

                @if (strtolower($protocolo->tipo ?? '') === 'agresion sexual')
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="denuncia_fiscalia" value="1"
                                   {{ !empty($protocolo->denuncia_fiscalia) ? 'checked' : '' }}>
                            Denuncia FiscalÃ­a
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="denuncia_tribunal" value="1"
                                   {{ !empty($protocolo->denuncia_tribunal) ? 'checked' : '' }}>
                            Denuncia Tribunal
                        </label>
                    </div>
                @endif
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Guardar etapa 3</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>


{{-- Etapa 4 --}}
<div class="modal fade" id="modal-etapa4" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:#0f172a; color:#e5e7eb;">
      <form method="POST" action="{{ url('protocolos/'.$protocolo->id) }}">
        @csrf @method('PUT')
        <input type="hidden" name="etapa" value="4">
        <div class="modal-header">
          <h4 class="modal-title">Etapa 4: Entrevistas apoderados</h4>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Reunión apoderado víctima (fecha/hora)</label>
                <input type="datetime-local" name="et4_reu_victima" class="form-control">
                <label class="mt-2">Modalidad víctima</label>
                <select name="et4_mod_victima" class="form-control">
                    <option value="">Seleccione...</option>
                    <option value="Presencial">Presencial</option>
                    <option value="Virtual">Virtual</option>
                </select>
            </div>
            <div class="form-group">
                <label>Reunión apoderado agresor (fecha/hora)</label>
                <input type="datetime-local" name="et4_reu_agresor" class="form-control">
                <label class="mt-2">Modalidad agresor</label>
                <select name="et4_mod_agresor" class="form-control">
                    <option value="">Seleccione...</option>
                    <option value="Presencial">Presencial</option>
                    <option value="Virtual">Virtual</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Guardar etapa 4</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Etapa 5 --}}
<div class="modal fade" id="modal-etapa5" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:#0f172a; color:#e5e7eb;">
      <form method="POST" action="{{ url('protocolos/'.$protocolo->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <input type="hidden" name="etapa" value="5">
        <div class="modal-header">
          <h4 class="modal-title">Etapa 5: Seguimiento</h4>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Plan de apoyo / acciones</label>
                <textarea name="et5_plan" class="form-control" rows="4" style="text-transform:uppercase;"></textarea>
            </div>
            <div class="form-group">
                <label>Psicólogo / profesional a cargo</label>
                <input type="text" name="et5_psico" class="form-control" style="text-transform:uppercase;">
            </div>
            <div class="form-group">
                <label>Derivación psicológica</label>
                <select name="derivacion_psico" class="form-control">
                    <option value="">Seleccione...</option>
                    <option value="si" {{ (old('derivacion_psico') ?? $protocolo->derivacion_psico ?? ') === 'si' ? 'selected' : '' }}>Sí</option>
                    <option value="no" {{ (old('derivacion_psico') ?? $protocolo->derivacion_psico ?? ') === 'no' ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div class="form-group">
                <label>Adjunto (opcional)</label>
                <div class="custom-file">
                    <input type="file" name="adjunto_seguimiento" class="custom-file-input" id="adjuntoSeg">
                    <label class="custom-file-label" for="adjuntoSeg">Seleccionar archivo</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Guardar etapa 5</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Etapa 6 --}}
<div class="modal fade" id="modal-etapa6" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:#0f172a; color:#e5e7eb;">
      <form method="POST" action="{{ url('protocolos/'.$protocolo->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <input type="hidden" name="etapa" value="6">
        <div class="modal-header">
          <h4 class="modal-title">Etapa 6: Informe de cierre</h4>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Informe de cierre (PDF/Word)</label>
                <div class="custom-file">
                    <input type="file" name="informe_cierre" class="custom-file-input" id="informeCierre">
                    <label class="custom-file-label" for="informeCierre">Seleccionar archivo</label>
                </div>
            </div>
            <div class="form-group">
                <label>Notas</label>
                <textarea name="et6_notas" class="form-control" rows="4" style="text-transform:uppercase; background:#0c1524; color:#e5e7eb; border:1px solid #334155;" placeholder="Agrega observaciones relevantes del cierre..."></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Guardar etapa 6</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Etapa 7 --}}
<div class="modal fade" id="modal-etapa7" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:#0f172a; color:#e5e7eb;">
      <form method="POST" action="{{ url('protocolos/'.$protocolo->id) }}">
        @csrf @method('PUT')
        <input type="hidden" name="etapa" value="7">
        <input type="hidden" name="estado" value="Archivado">
        <div class="modal-header">
          <h4 class="modal-title">Etapa 7: Cierre del protocolo</h4>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Detalle final</label>
                <textarea name="det_final" class="form-control" rows="4" style="text-transform:uppercase; background:#0c1524; color:#e5e7eb; border:1px solid #334155;" placeholder="Resumen final del protocolo..."></textarea>
            </div>
            <div class="form-group">
                <label>Fecha cierre</label>
                <input type="datetime-local" name="et7_fecha" class="form-control" value="{{ $fechaCierre }}">
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Guardar etapa 7</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
    (function(){
        const selDelito = document.getElementById('sel-delito-3');
        const bloque = document.getElementById('bloque-sancion');
        if (selDelito && bloque) {
            const toggle = () => bloque.style.display = selDelito.value === 'no' ? 'block' : 'none';
            selDelito.addEventListener('change', toggle);
            toggle();
        }

        document.querySelectorAll('.custom-file-input').forEach(function(inp){
            inp.addEventListener('change', function(){
                var label = inp.nextElementSibling;
                if(label){ label.textContent = inp.files.length ? inp.files[0].name : 'Seleccionar archivo'; }
            });
        });
    })();
</script>
@endsection











