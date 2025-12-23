@extends('layouts.app')

@php
    use Carbon\Carbon;

    $fechaAct   = $protocolo->fecha_activacion ? Carbon::parse($protocolo->fecha_activacion)->format('Y-m-d\TH:i') : '';
    $fechaCierre= $protocolo->fecha_cierre ? Carbon::parse($protocolo->fecha_cierre)->format('Y-m-d\TH:i') : '';

    $obs       = $protocolo->observacion_cierre ?? '';
    $obsLower  = strtolower($obs);

    // done para vulneración
    
@endphp

@section('content')
@if(session('success'))
  <div class="alert alert-success" style="margin-top:10px;">
    {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger" style="margin-top:10px;">
    {{ session('error') }}
  </div>
@endif


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
@if(session('success'))
  <div class="alert alert-success" style="margin-top:10px;">
    {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger" style="margin-top:10px;">
    {{ session('error') }}
  </div>
@endif


    {{-- Botón volver --}}
    <div class="mb-3">
        <a href="{{ url('dashboard') }}" class="btn btn-ghost"><i class="fa fa-arrow-left"></i> Volver al Dashboard</a>
    </div>

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
                <p class="muted" style="margin:0;"><strong>Folio:</strong> {{ $protocolo->folio ?? '—' }}</p>
                <p class="muted" style="margin:0;"><strong>Tipo:</strong> {{ $protocolo->tipo_id == 2 ? 'Agresión sexual' : 'Vulneración de derechos' }}</p>
                <p class="muted" style="margin:0;"><strong>Estudiante:</strong> {{ $protocolo->estudiante->nombre ?? '—' }}</p>
                <p class="muted" style="margin:0;"><strong>Activación:</strong> {{ $protocolo->fecha_activacion ?? 'Pendiente' }}</p>
                <p class="muted" style="margin:0;"><strong>Cierre:</strong> {{ $protocolo->fecha_cierre ?? 'Pendiente' }}</p>
                <p class="muted" style="margin:0;"><strong>Obs. Cierre:</strong> {{ $protocolo->observacion_cierre ?? '—' }}</p>
            </div>
        </div>

        {{-- Panel derecho: etapas y modales --}}
        <div class="col-md-8 mb-3">
            @if($protocolo->tipo_id == 2)
                @include('protocolos.partials.etapas_agresion', ['protocolo' => $protocolo, 'done' => $done, 'fechaAct' => $fechaAct, 'fechaCierre' => $fechaCierre])
            @else
                @include('protocolos.partials.etapas_vulneracion', ['protocolo' => $protocolo, 'done' => $done, 'fechaAct' => $fechaAct, 'fechaCierre' => $fechaCierre])
            @endif
        </div>
    </div>
</div>
@endsection
