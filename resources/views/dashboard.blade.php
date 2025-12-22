@extends('layouts.app')

@section('htmlheader_title')
    Dashboard
@endsection

@section('content')
<style>
    :root {
        /* Paleta solicitada, adaptada a modo oscuro */
        --bg: #0a0f1a;          /* base oscura */
        --panel: #0f1726;       /* panel oscuro */
        --card: #111a2b;        /* tarjeta ligeramente más clara */
        --stroke: #1f2a3d;      /* borde sutil */
        --text: #e5e7eb;        /* texto claro */
        --muted: #9aa3b5;       /* texto secundario */
        --accent: #2C5282;      /* azul navy suave */
        --accent-2: #4A6FA6;    /* secundario frío */
        --danger: #e56a6a;      /* rojo suave */
        --warn: #ED8936;        /* naranja suave */
        --success: #68D391;     /* verde menta seco */
        --shadow: 0 14px 28px rgba(0,0,0,0.35);
    }
    body { background: var(--bg); }
    .wrap { padding: 14px 0 32px; }
    .title-row { display:flex; align-items:center; justify-content:space-between; color:var(--text); margin-bottom:12px; }
    .section-label { color:var(--muted); text-transform:uppercase; letter-spacing:0.08em; font-size:12px; margin-bottom:6px; }
    .badge-pill { border:1px solid var(--stroke); border-radius:999px; padding:6px 12px; color:var(--muted); font-size:12px; display:inline-flex; gap:8px; align-items:center; }
    .card { background: var(--card); border:1px solid var(--stroke); border-radius:12px; color:var(--text); box-shadow: var(--shadow); }
    .card-soft { background: var(--panel); border:1px solid var(--stroke); border-radius:12px; color:var(--text); box-shadow: var(--shadow); }
    .stat-vert { padding:12px; border-radius:10px; border:1px solid var(--stroke); background: var(--panel); margin-bottom:10px; display:flex; align-items:center; gap:10px; }
    .stat-icon { width:38px; height:38px; border-radius:10px; display:grid; place-items:center; color:white; font-size:17px; }
    .stat-meta { display:flex; flex-direction:column; }
    .stat-meta .label { color:var(--muted); letter-spacing:0.04em; text-transform:uppercase; font-size:11px; margin:0; }
    .stat-meta .value { font-size:24px; font-weight:800; margin:0; color:var(--text); }
    .cta-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:12px; }
    .cta { padding:14px; border-radius:12px; border:1px solid var(--stroke); background: linear-gradient(140deg, rgba(44,82,130,0.12), rgba(15,23,38,0.96)); }
    .cta.danger { background: linear-gradient(140deg, rgba(237,137,54,0.18), rgba(15,23,38,0.96)); }
    .cta h4 { margin:0 0 6px 0; }
    .cta p { margin:0 0 10px 0; color:var(--muted); }
    .btn-solid { border:none; border-radius:10px; font-weight:700; padding:9px 12px; color:#fff; background:var(--accent); }
    .btn-solid.danger { background:var(--warn); color:#0a0f1a; }
    .btn-ghost { border:1px solid var(--stroke); background:transparent; color:var(--text); border-radius:10px; padding:6px 10px; font-weight:600; }
    .btn-ghost:hover { border-color: var(--accent-2); color: var(--accent-2); }
    .badge-state { padding:5px 10px; border-radius:10px; font-weight:700; font-size:12px; color:white; display:inline-block; }
    .table > thead > tr > th { border-bottom:none; color:var(--muted); background: var(--panel); }
    .table > tbody > tr { border-top:1px solid var(--stroke); }
    .link-muted { color:var(--muted); text-decoration:none; }
    .link-muted:hover { color:var(--accent); }
</style>

<div class="container-fluid wrap">
    {{-- Cabecera --}}
    <div class="row mb-2">
        <div class="col-12 title-row">
            <div>
                <div class="section-label">Panel de Control</div>
                <h2 style="margin:0;">ConviveCloud</h2>
            </div>
            <span class="badge-pill"><i class="fa fa-briefcase"></i> Operación confidencial</span>
        </div>
    </div>

    <div class="row">
        {{-- Columna izquierda: estados --}}
        <div class="col-lg-3 col-md-4 mb-3">
            <div class="stat-vert">
                <div class="stat-icon" style="background:var(--accent);"><i class="fa fa-flag"></i></div>
                <div class="stat-meta">
                    <p class="label">Activos</p>
                    <p class="value">{{ $prot_activos ?? 0 }}</p>
                </div>
            </div>
            <div class="stat-vert">
                <div class="stat-icon" style="background:var(--success);"><i class="fa fa-refresh"></i></div>
                <div class="stat-meta">
                    <p class="label">En ejecución</p>
                    <p class="value">{{ $prot_ejecucion ?? 0 }}</p>
                </div>
            </div>
            <div class="stat-vert">
                <div class="stat-icon" style="background:#7b7bea;"><i class="fa fa-check-circle"></i></div>
                <div class="stat-meta">
                    <p class="label">Cerrados</p>
                    <p class="value">{{ $prot_cerrados ?? 0 }}</p>
                </div>
            </div>
            <div class="stat-vert">
                <div class="stat-icon" style="background:var(--accent-2);"><i class="fa fa-archive"></i></div>
                <div class="stat-meta">
                    <p class="label">Archivados</p>
                    <p class="value">{{ $archivados ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- Columna derecha: acciones, poblaciones y tabla --}}
        <div class="col-lg-9 col-md-8">
            {{-- Bloques de acción --}}
            <div class="card-soft mb-3" style="padding:14px;">
                <div class="section-label">Protocolos de actuación</div>
                <div class="cta-grid">
                    <div class="cta">
                        <h4>Vulneración de Derechos</h4>
                        <p>Activar protocolo ante sospecha o confirmación de vulneración de derechos.</p>
                        <a href="{{ url('protocolos/create?tipo=vulneracion') }}" class="btn btn-solid">Iniciar protocolo →</a>
                    </div>
                    <div class="cta danger">
                        <h4>Agresión Sexual</h4>
                        <p>Procedimiento inmediato para hechos de connotación sexual.</p>
                        <a href="{{ url('protocolos/create?tipo=agresion_sexual') }}" class="btn btn-solid danger">
                            Iniciar protocolo <i class="fa fa-exclamation-triangle"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Gestión de poblaciones --}}
            <div class="card-soft mb-4" style="padding:14px;">
                <div class="section-label">Gestión de poblaciones escolares</div>
                <div class="d-flex flex-wrap" style="gap:12px;">
                    <div style="flex:1; min-width:240px;">
                        <div class="card" style="padding:12px; border-radius:10px; border:1px solid var(--stroke);">
                            <p class="label" style="margin:0; color:var(--muted); text-transform:uppercase; letter-spacing:0.06em; font-size:11px;">Estudiantes registrados</p>
                            <p style="margin:4px 0 10px 0; font-size:22px; font-weight:800; color:var(--text);">{{ $total_estudiantes ?? 0 }}</p>
                            <div class="d-flex" style="gap:8px;">
                                <a href="{{ url('estudiantes') }}" class="btn btn-ghost btn-sm">Ver listado</a>
                                <a href="{{ url('estudiantes/create') }}" class="btn btn-solid btn-sm">Agregar</a>
                            </div>
                        </div>
                    </div>
                    <div style="flex:1; min-width:240px;">
                        <div class="card" style="padding:12px; border-radius:10px; border:1px solid var(--stroke);">
                            <p class="label" style="margin:0; color:var(--muted); text-transform:uppercase; letter-spacing:0.06em; font-size:11px;">Docentes (próximamente)</p>
                            <p style="margin:4px 0 10px 0; font-size:18px; font-weight:700; color:var(--muted);">Pendiente</p>
                            <div class="d-flex" style="gap:8px;">
                                <button class="btn btn-ghost btn-sm" disabled title="Próximamente">Ver listado</button>
                                <button class="btn btn-solid btn-sm" disabled title="Próximamente">Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Últimos protocolos --}}
            <div class="card-soft">
                <div class="card-header d-flex justify-content-between align-items-center" style="padding:12px 14px; border-bottom:1px solid var(--stroke); font-weight:700;">
                    Últimos Protocolos Registrados
                </div>
                <div class="card-body table-responsive no-padding">
                    <table class="table" style="margin:0; color:var(--text);">
                        <thead style="background:var(--panel);">
                            <tr>
                                <th>Folio</th>
                                <th>Tipo</th>
                                <th>Estudiante</th>
                                <th>Fecha Apertura</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($ultimos_protocolos ?? [] as $protocolo)
                            @php
                                $stateColors = [
                                    'Activo' => 'var(--accent)',
                                    'En Ejecucion' => 'var(--success)',
                                    'Cerrado' => '#7b7bea',
                                    'Archivado' => 'var(--accent-2)',
                                ];
                                $bg = $stateColors[$protocolo->estado] ?? '#4b5563';
                            @endphp
                            <tr>
                                <td style="font-weight:700; color:var(--warn);">{{ $protocolo->folio }}</td>
                                <td>{{ $protocolo->tipo }}</td>
                                <td>{{ $protocolo->estudiante_nombre ?? 'Sin dato' }}</td>
                                <td>{{ \Carbon\Carbon::parse($protocolo->created_at)->format('d-m-Y') }}</td>
                                <td><span class="badge-state" style="background:{{ $bg }};">{{ $protocolo->estado }}</span></td>
                                <td class="text-center">
                                    <a href="{{ url('protocolos/'.$protocolo->id.'/edit') }}" class="btn btn-ghost btn-sm" style="padding:6px 10px;">
                                        <i class="fa fa-edit"></i> Gestionar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center" style="padding:22px; color:var(--muted);">No hay protocolos registrados.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="text-center mt-3">
                        <a class="link-muted" href="{{ url('protocolos') }}">Ver historial completo →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="row mt-5 mb-4">
        <div class="col-12 text-center" style="color:var(--muted);">
            <div class="section-label" style="margin-bottom:4px;">ConviveCloud</div>
            <div style="color:var(--text); font-weight:700;">Plataforma de gestión de convivencia escolar</div>
            <small style="color:var(--muted);">Operación confidencial y segura</small>
        </div>
    </div>
</div>
@endsection
