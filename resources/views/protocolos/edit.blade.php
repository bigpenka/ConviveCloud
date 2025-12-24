@extends('layouts.app')

@php
    use Carbon\Carbon;

    $fechaAct    = $protocolo->fecha_activacion ? Carbon::parse($protocolo->fecha_activacion)->format('Y-m-d\TH:i') : '';
    $fechaCierre = $protocolo->fecha_cierre ? Carbon::parse($protocolo->fecha_cierre)->format('Y-m-d\TH:i') : '';
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
    .muted { color:#9ca3af; font-size: 13px; }
    .alert-soft { border-radius:10px; padding:12px 14px; border:1px solid rgba(249,115,22,.35); background:rgba(249,115,22,.08); color:#e5e7eb; }
</style>

<div class="container-fluid" style="padding-top:10px; padding-bottom:20px;">
    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-3">{{ session('error') }}</div>
    @endif

    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ url('dashboard') }}" class="btn btn-ghost"><i class="fa fa-arrow-left"></i> Volver al Dashboard</a>
        <span class="badge" style="background:#2563eb; padding: 10px;">Estado Actual: {{ $protocolo->estado }}</span>
    </div>

    {{-- Fila de Resumen y Agresor --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="left-card h-100">
                <div style="text-transform:uppercase; letter-spacing:.08em; color:#9ca3af; font-size:11px; margin-bottom:10px;">Resumen del Caso</div>
                <div class="row">
                    <div class="col-6">
                        <p class="muted mb-1"><strong>Folio:</strong> {{ $protocolo->folio }}</p>
                        <p class="muted mb-1"><strong>Estudiante:</strong> {{ $protocolo->estudiante->nombre }} {{ $protocolo->estudiante->apellido }}</p>
                    </div>
                    <div class="col-6 border-left border-secondary">
                        <p class="muted mb-1"><strong>Tipo:</strong> {{ $protocolo->tipo_id == 2 ? 'Agresión Sexual' : 'Vulneración' }}</p>
                        <p class="muted mb-1"><strong>Activación:</strong> {{ $protocolo->fecha_activacion ?? 'No activado' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="left-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div style="text-transform:uppercase; letter-spacing:.08em; color:#9ca3af; font-size:11px;">Presunto Agresor / Responsable</div>
                    <button class="btn btn-sm btn-ghost" style="font-size:10px;" data-toggle="modal" data-target="#modalAsignarAgresor">
                        <i class="fa fa-user-plus"></i> {{ $protocolo->agresor_id ? 'Cambiar' : 'Asignar' }}
                    </button>
                </div>
                
                @if($protocolo->agresor_id)
                    <div class="p-2 rounded" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2);">
                        <p class="mb-0 font-weight-bold" style="color: #f87171;">
                            <i class="fa fa-gavel"></i> Identificado: {{ $protocolo->agresor_nombre ?? 'Cargando datos...' }}
                        </p>
                        <small class="text-uppercase muted" style="font-size:9px;">Vínculo: {{ $protocolo->agresor_tipo }}</small>
                    </div>
                @else
                    <div class="text-center py-3 border border-dashed border-secondary rounded">
                        <small class="muted"><i class="fa fa-search"></i> Pendiente de identificación en investigación</small>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($protocolo->tipo_id == 2)
                @include('protocolos.partials.etapas_agresion', ['protocolo' => $protocolo, 'done' => $done])
            @else
                @include('protocolos.partials.etapas_vulneracion', ['protocolo' => $protocolo, 'done' => $done])
            @endif
        </div>
    </div>
</div>

{{-- Modal Asignar Agresor --}}
<div class="modal fade" id="modalAsignarAgresor" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white border-secondary">
            <form action="{{ route('protocolos.asignar-agresor', $protocolo->id) }}" method="POST">
                @csrf
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">Identificar Responsable</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="muted small">Categoría</label>
                        <select name="agresor_tipo" id="tipoAgresor" class="form-control bg-dark text-white border-secondary" required>
                            <option value="" disabled selected>Seleccione...</option>
                            <option value="estudiante">Estudiante</option>
                            <option value="docente">Docente / Funcionario</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="muted small">Nombre de la Persona</label>
                        <select name="agresor_id" id="listaAgresores" class="form-control bg-dark text-white border-secondary" required disabled>
                            <option value="">Seleccione categoría primero...</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="submit" class="btn btn-primary px-4">Vincular al Caso</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoAgresor = document.getElementById('tipoAgresor');
    const listaAgresores = document.getElementById('listaAgresores');

    tipoAgresor.addEventListener('change', function() {
        const tipo = this.value;
        listaAgresores.disabled = false;
        listaAgresores.innerHTML = '<option value="">Cargando...</option>';

        fetch(`/api/buscar-personas?tipo=${tipo}`)
            .then(res => res.json())
            .then(data => {
                listaAgresores.innerHTML = '<option value="" disabled selected>Seleccione persona...</option>';
                data.forEach(p => {
                    listaAgresores.innerHTML += `<option value="${p.id}">${p.nombre} ${p.apellido} (${p.rut})</option>`;
                });
            })
            .catch(err => {
                console.error(err);
                listaAgresores.innerHTML = '<option value="">Error al cargar</option>';
            });
    });
});
</script>
@endsection