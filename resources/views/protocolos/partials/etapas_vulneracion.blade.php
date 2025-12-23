<div class="left-card">
  <div class="section-label" style="text-transform:uppercase; letter-spacing:.08em; color:#9ca3af;">
    <i class="fa fa-check-square-o"></i> Etapas del protocolo (Vulneración)
  </div>

  <div class="etapa-card {{ $done[1] ? 'etapa-done' : '' }}">
    <div>
      <p class="etapa-label">Etapa 1 - Activación</p>
      <p class="etapa-desc">Pasar a En Ejecución y fijar inicio.</p>
    </div>
    <button class="btn-ghost" data-toggle="modal" data-target="#modal-etapa1">Gestionar</button>
  </div>

  <div class="etapa-card {{ $done[2] ? 'etapa-done' : '' }}">
    <div>
      <p class="etapa-label">Etapa 2 - Detalle de hechos y entrevista</p>
      <p class="etapa-desc">Fecha/hora del hecho, relato y adjunto opcional.</p>
    </div>
    <button class="btn-ghost" data-toggle="modal" data-target="#modal-etapa2">Gestionar</button>
  </div>

  <div class="etapa-card {{ $done[3] ? 'etapa-done' : '' }}">
    <div>
      <p class="etapa-label">Etapa 3 - Clasificación (¿es delito?)</p>
      <p class="etapa-desc">Si es delito: denuncia inmediata. Si no, sanción.</p>
    </div>
    <button class="btn-ghost" data-toggle="modal" data-target="#modal-etapa3">Gestionar</button>
  </div>

  <div class="etapa-card {{ $done[4] ? 'etapa-done' : '' }}">
    <div>
      <p class="etapa-label">Etapa 4 - Entrevistas apoderados</p>
      <p class="etapa-desc">Agendar reuniones víctima/agresor.</p>
    </div>
    <button class="btn-ghost" data-toggle="modal" data-target="#modal-etapa4">Gestionar</button>
  </div>

  <div class="etapa-card {{ $done[5] ? 'etapa-done' : '' }}">
    <div>
      <p class="etapa-label">Etapa 5 - Seguimiento</p>
      <p class="etapa-desc">Plan de apoyo, psicólogo y adjuntos.</p>
    </div>
    <button class="btn-ghost" data-toggle="modal" data-target="#modal-etapa5">Gestionar</button>
  </div>

  <div class="etapa-card {{ $done[6] ? 'etapa-done' : '' }}">
    <div>
      <p class="etapa-label">Etapa 6 - Informe de cierre</p>
      <p class="etapa-desc">Subir informe de cierre.</p>
    </div>
    <button class="btn-ghost" data-toggle="modal" data-target="#modal-etapa6">Gestionar</button>
  </div>

  <div class="etapa-card {{ $done[7] ? 'etapa-done' : '' }}">
    <div>
      <p class="etapa-label">Etapa 7 - Cierre del protocolo</p>
      <p class="etapa-desc">Detalle final y cierre.</p>
    </div>
    <button class="btn-ghost" data-toggle="modal" data-target="#modal-etapa7">Gestionar</button>
  </div>
</div>

{{-- Modales vulneración --}}

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
                <label>Fecha/Hora inicio ejecución</label>
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
                <label>Archivo (opcional)</label>
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
          <h4 class="modal-title">Etapa 3: Clasificación (¿es delito?)</h4>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>¿Es delito?</label>
                <select name="et3_delito" class="form-control" id="sel-delito-3">
                    <option value="no">No</option>
                    <option value="si">Sí</option>
                </select>
                <small class="muted">Si es delito: denuncia inmediata.</small>
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
                    </select>
                </div>
                <div class="form-group">
                    <label>Días de sanción</label>
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
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="denuncia_policia" value="1"
                               {{ !empty($protocolo->denuncia_policia) ? 'checked' : '' }}>
                        Denuncia a Policía
                    </label>
                </div>
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
<script>
  (function(){
    const sel = document.getElementById('sel-delito-3');
    const bloque = document.getElementById('bloque-sancion');
    if (sel && bloque) {
      const toggle = () => bloque.style.display = sel.value === 'no' ? 'block' : 'none';
      sel.addEventListener('change', toggle);
      toggle();
    }
  })();
</script>

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
                    <option value="si" {{ (old('derivacion_psico') ?? $protocolo->derivacion_psico ?? '') === 'si' ? 'selected' : '' }}>Sí</option>
                    <option value="no" {{ (old('derivacion_psico') ?? $protocolo->derivacion_psico ?? '') === 'no' ? 'selected' : '' }}>No</option>
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
