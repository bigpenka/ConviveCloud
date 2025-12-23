@php
  $donePre = $done['pre']  ?? false;
  $doneE1  = $done['e1']   ?? false;
  $doneE2  = $done['e2']   ?? false;
  $doneE3  = $done['e3']   ?? false;
  $doneE45 = $done['e45']  ?? false;
  $doneE6  = $done['e6']   ?? false;
  $doneE7  = $done['e7']   ?? false;

  $enableE1  = $donePre;
  $enableE2  = $donePre && $doneE1;
  $enableE3  = $enableE2;
  $enableE45 = $enableE3;
  $enableE6  = $enableE45;
  $enableE7  = $enableE6;
@endphp

<div class="left-card">
  <div class="section-label" style="text-transform:uppercase; letter-spacing:.08em; color:#9ca3af;">
    <i class="fa fa-check-square-o"></i> Etapas del protocolo (Agresión Sexual)
  </div>

  {{-- Preliminar --}}
  <div class="etapa-card {{ $donePre ? 'etapa-done' : '' }}" style="{{ $donePre ? '' : 'border-color:#b91c1c;' }}">
    <div>
      <p class="etapa-label">Preliminar: Comunicación y Denuncia</p>
      <p class="etapa-desc">Lesiones, denuncia 24h, adjunto comprobante.</p>
    </div>
    <button class="btn-ghost" data-toggle="modal" data-target="#modal-as-pre">Gestionar</button>
  </div>

  {{-- Etapa 1 --}}
  <div class="etapa-card {{ $doneE1 ? 'etapa-done' : '' }}">
    <div><p class="etapa-label">Etapa 1: Activación</p><p class="etapa-desc">Medidas de resguardo y notificación.</p></div>
    <button class="btn-ghost" data-toggle="modal" data-target="#modal-as-e1" {{ $enableE1 ? '' : 'disabled' }}>Gestionar</button>
  </div>

  {{-- Etapa 2 --}}
  <div class="etapa-card {{ $doneE2 ? 'etapa-done' : '' }}">
    <div><p class="etapa-label">Etapa 2: Investigación</p><p class="etapa-desc">Bitácora de diligencias, entrevistas, evidencias.</p></div>
    <button class="btn-ghost" data-toggle="modal" data-target="#modal-as-e2" {{ $enableE2 ? '' : 'disabled' }}>Gestionar</button>
  </div>

  {{-- Etapa 3 --}}
  <div class="etapa-card {{ $doneE3 ? 'etapa-done' : '' }}">
    <div><p class="etapa-label">Etapa 3: Informe de Cierre (ECE)</p><p class="etapa-desc">Conclusiones y sugerencias.</p></div>
    <button class="btn-ghost" data-toggle="modal" data-target="#modal-as-e3" {{ $enableE3 ? '' : 'disabled' }}>Gestionar</button>
  </div>

  {{-- Etapa 4 y 5 --}}
  <div class="etapa-card {{ $doneE45 ? 'etapa-done' : '' }}">
    <div><p class="etapa-label">Etapa 4 y 5: Informe Final e Inicio de Ejecución</p><p class="etapa-desc">Plan definitivo y notificación a involucrados.</p></div>
    <button class="btn-ghost" data-toggle="modal" data-target="#modal-as-e4-5" {{ $enableE45 ? '' : 'disabled' }}>Gestionar</button>
  </div>

  {{-- Etapa 6 --}}
  <div class="etapa-card {{ $doneE6 ? 'etapa-done' : '' }}">
    <div><p class="etapa-label">Etapa 6: Seguimiento</p><p class="etapa-desc">Monitoreo, citas de seguimiento, notas.</p></div>
    <button class="btn-ghost" data-toggle="modal" data-target="#modal-as-e6" {{ $enableE6 ? '' : 'disabled' }}>Gestionar</button>
  </div>

  {{-- Etapa 7 --}}
  <div class="etapa-card {{ $doneE7 ? 'etapa-done' : '' }}">
    <div><p class="etapa-label">Etapa 7: Cierre del protocolo</p><p class="etapa-desc">Detalle final, fecha cierre, firma/archivo.</p></div>
    <button class="btn-ghost" data-toggle="modal" data-target="#modal-as-e7" {{ $enableE7 ? '' : 'disabled' }}>Gestionar</button>
  </div>
</div>

{{-- MODALES --}}

{{-- Preliminar --}}
<div class="modal fade" id="modal-as-pre" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:#0f172a; color:#e5e7eb;">
      <form method="POST" action="{{ url('protocolos/'.$protocolo->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <input type="hidden" name="etapa" value="as_pre">
        <div class="modal-header" style="border-top:3px solid #ef4444;">
          <h4 class="modal-title">Preliminar: Comunicación y Denuncia</h4>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <label>¿Hay lesiones?</label>
            <select name="as_pre_lesiones" class="form-control" id="as_pre_lesiones">
              <option value="no">No</option>
              <option value="si">Sí</option>
            </select>
            <div id="as_pre_lesiones_block" style="display:none; margin-top:8px;">
              <small>Contactos: Carabineros 133 / PDI 134 / SAMU 131</small>
              <textarea name="as_pre_observaciones" class="form-control mt-2" rows="3" placeholder="Motivo / detalle..."></textarea>
            </div>
            <label class="mt-2">Adjuntar comprobante denuncia (PDF/JPG)</label>
            <input type="file" name="as_pre_adjunto_denuncia" class="form-control">
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Guardar preliminar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  (function(){
    const sel = document.getElementById('as_pre_lesiones');
    const blk = document.getElementById('as_pre_lesiones_block');
    if(sel && blk){ const t=()=> blk.style.display = sel.value==='si'?'block':'none'; sel.addEventListener('change', t); t(); }
  })();
</script>

{{-- Etapa 1 --}}
<div class="modal fade" id="modal-as-e1" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:#0f172a; color:#e5e7eb;">
      <form method="POST" action="{{ url('protocolos/'.$protocolo->id) }}">
        @csrf @method('PUT')
        <input type="hidden" name="etapa" value="as_e1">
        <div class="modal-header">
          <h4 class="modal-title">Etapa 1: Activación</h4>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <label>Medidas de resguardo (se guardan en tabla hija)</label>
            <div class="form-group">
              <div><label><input type="checkbox" name="as_e1_medidas[]" value="Separación de involucrados"> Separación de involucrados</label></div>
              <div><label><input type="checkbox" name="as_e1_medidas[]" value="Tutor sombra"> Tutor sombra</label></div>
              <div><label><input type="checkbox" name="as_e1_medidas[]" value="Derivación a psicólogo"> Derivación a psicólogo</label></div>
              <div><label><input type="checkbox" name="as_e1_medidas[]" value="Apoyo pedagógico"> Apoyo pedagógico</label></div>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" name="as_e1_notificacion_auto" value="1" {{ $protocolo->as_e1_notificacion_auto ? 'checked' : '' }}> Notificación automática a padres</label>
            </div>
            <div class="form-group">
              <label>Notas</label>
              <textarea name="as_e1_notas" class="form-control" rows="3">{{ $protocolo->as_e1_notas }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit" {{ $enableE1 ? '' : 'disabled' }}>Guardar etapa 1</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Etapa 2 --}}
<div class="modal fade" id="modal-as-e2" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:#0f172a; color:#e5e7eb;">
      <form method="POST" action="{{ url('protocolos/'.$protocolo->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <input type="hidden" name="etapa" value="as_e2">

        <div class="modal-header">
          <h4 class="modal-title">Etapa 2: Investigación</h4>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Diligencia / Bitácora</label>
            <select name="as_e2_tipo" class="form-control">
              <option value="">Seleccione...</option>
              <option value="Declaración testigo">Declaración testigo</option>
              <option value="Declaración víctima">Declaración víctima</option>
              <option value="Entrevista">Entrevista</option>
              <option value="Revisión CCTV">Revisión CCTV</option>
              <option value="Pericia/Informe médico">Pericia/Informe médico</option>
              <option value="Otro">Otro</option>
            </select>
          </div>
          <div class="form-group">
            <label>Descripción / hallazgos</label>
            <textarea name="as_e2_desc" class="form-control" rows="4"></textarea>
          </div>
          <div class="form-group">
            <label>Fecha diligencia</label>
            <input type="datetime-local" name="as_e2_fecha" class="form-control">
          </div>
          <div class="form-group">
            <label>Adjunto (opcional)</label>
            <input type="file" name="as_e2_adjunto" class="form-control">
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
<div class="modal fade" id="modal-as-e3" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:#0f172a; color:#e5e7eb;">
      <form method="POST" action="{{ url('protocolos/'.$protocolo->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <input type="hidden" name="etapa" value="as_e3">
        <div class="modal-header">
          <h4 class="modal-title">Etapa 3: Informe de Cierre (ECE)</h4>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        </div>
        <div class="modal-body">
        
            <div class="form-group">
              <label>Conclusiones</label>
              <textarea name="as_e3_conclusiones" class="form-control" rows="4">{{ $protocolo->as_e3_conclusiones }}</textarea>
            </div>
            <div class="form-group">
              <label>Adjuntar informe (PDF/Word)</label>
              <input type="file" name="as_e3_adjunto_informe" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit" {{ $enableE3 ? '' : 'disabled' }}>Guardar etapa 3</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Etapa 4 y 5 --}}
<div class="modal fade" id="modal-as-e4-5" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:#0f172a; color:#e5e7eb;">
      <form method="POST" action="{{ url('protocolos/'.$protocolo->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <input type="hidden" name="etapa" value="as_e4_5">
        <div class="modal-header">
          <h4 class="modal-title">Etapa 4 y 5: Informe Final e Inicio Ejecución</h4>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        </div>
        <div class="modal-body">
           {{-- Checkbox --}}
<div class="form-group">
    <label>
        <input type="checkbox" id="chk-notificar" name="as_e4_5_notificar" value="1">
        Notificar vía correo a padres/apoderados
    </label>
</div>

<div class="form-group">
    <label>Adjuntar PDF Informe Final</label>
    <div class="custom-file">
        <input type="file" name="as_e4_5_pdf" class="custom-file-input" id="as_e4_5_pdf">
        <label class="custom-file-label" for="as_e4_5_pdf">Seleccionar archivo</label>
    </div>
</div>

{{-- Correos (se muestran sólo si el checkbox está activo) --}}
<div id="correo-destino-wrap" style="display:none;">
    <div class="form-group">
        <label>Correo apoderado 1</label>
        <input type="email" name="as_e4_5_correo1" class="form-control" placeholder="apoderado1@correo.cl">
    </div>
    <div class="form-group">
        <label>Correo apoderado 2</label>
        <input type="email" name="as_e4_5_correo2" class="form-control" placeholder="apoderado2@correo.cl">
    </div>
</div>

<div class="form-group">
    <label>Notas</label>
    <textarea name="as_e4_5_notas" class="form-control" rows="3"></textarea>
</div>

 
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit" {{ $enableE45 ? '' : 'disabled' }}>Guardar etapa 4 y 5</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Etapa 6 --}}
<div class="modal fade" id="modal-as-e6" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:#0f172a; color:#e5e7eb;">
      <form method="POST" action="{{ url('protocolos/'.$protocolo->id) }}">
        @csrf @method('PUT')
        <input type="hidden" name="etapa" value="as_e6">
        <div class="modal-header">
          <h4 class="modal-title">Etapa 6: Seguimiento</h4>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label>Notas / seguimiento</label>
              <textarea name="as_e6_notas" class="form-control" rows="3">{{ $protocolo->as_e6_notas }}</textarea>
            </div>
            <div class="form-group">
              <label>Registrar cita de seguimiento</label>
              <input type="datetime-local" name="as_e6_cita_fecha" class="form-control">
              <textarea name="as_e6_cita_nota" class="form-control mt-2" rows="2" placeholder="Nota de la cita"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit" {{ $enableE6 ? '' : 'disabled' }}>Guardar etapa 6</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Etapa 7 --}}
<div class="modal fade" id="modal-as-e7" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:#0f172a; color:#e5e7eb;">
      <form method="POST" action="{{ url('protocolos/'.$protocolo->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <input type="hidden" name="etapa" value="as_e7">
        <input type="hidden" name="estado" value="Archivado">
        <div class="modal-header">
          <h4 class="modal-title">Etapa 7: Cierre del protocolo</h4>
          <button type="button" class="close" data-dismiss="modal" style="color:#fff;"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label>Detalle final</label>
              <textarea name="as_e7_detalle_final" class="form-control" rows="4">{{ $protocolo->as_e7_detalle_final }}</textarea>
            </div>
            <div class="form-group">
              <label>Fecha cierre</label>
              <input type="datetime-local" name="as_e7_fecha_cierre" class="form-control" value="{{ $protocolo->as_e7_fecha_cierre ? \Carbon\Carbon::parse($protocolo->as_e7_fecha_cierre)->format('Y-m-d\TH:i') : '' }}">
            </div>
            <div class="checkbox">
              <label><input type="checkbox" id="chk-firma" name="as_e7_firma_digital" value="1" {{ $protocolo->as_e7_firma_digital ? 'checked' : '' }}> Firma digital</label>
            </div>
            <div id="firma-wrap" style="display:none;">
              <div class="form-group">
                <label>Archivo de firma (PDF/imagen)</label>
                <input type="file" name="as_e7_firma_archivo" class="form-control">
              </div>
              <div class="form-group">
                <label>Código o referencia de firma</label>
                <input type="text" name="as_e7_firma_codigo" class="form-control" placeholder="TOKEN / referencia">
              </div>
            </div>
            <div class="form-group">
              <label>Certificado PDF (opcional)</label>
              <input type="file" name="as_e7_certificado_pdf" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit" {{ $enableE7 ? '' : 'disabled' }}>Guardar etapa 7</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chk = document.getElementById('chk-notificar');
    const wrap = document.getElementById('correo-destino-wrap');
    const chkFirma = document.getElementById('chk-firma');
    const wrapFirma = document.getElementById('firma-wrap');

    if (chk && wrap) {
        const toggle = () => wrap.style.display = chk.checked ? 'block' : 'none';
        chk.addEventListener('change', toggle);
        toggle();
    }
    if (chkFirma && wrapFirma) {
        const toggleFirma = () => wrapFirma.style.display = chkFirma.checked ? 'block' : 'none';
        chkFirma.addEventListener('change', toggleFirma);
        toggleFirma();
    }
    document.querySelectorAll('.custom-file-input').forEach(inp => {
        inp.addEventListener('change', () => {
            const lbl = inp.nextElementSibling;
            if (lbl) lbl.textContent = inp.files.length ? inp.files[0].name : 'Seleccionar archivo';
        });
    });
});
</script>
@endsection

