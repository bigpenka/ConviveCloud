@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="background-color:#111827; color:#fff; border:1px solid #374151;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Protocolos</h4>
            <a href="{{ url('protocolos/create?tipo=vulneracion') }}" class="btn btn-sm btn-primary">Nuevo</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0" style="color:#fff;">
                    <thead style="background:#1f2937;">
                        <tr>
                            <th>Folio</th>
                            <th>Tipo</th>
                            <th>Estudiante</th>
                            <th>Fecha Apertura</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($protocolos as $protocolo)
                            <tr>
                                <td>{{ $protocolo->folio }}</td>
                                <td>{{ $protocolo->tipo }}</td>
                                <td>{{ $protocolo->estudiante->nombre ?? '—' }} {{ $protocolo->estudiante->apellido ?? '' }}</td>
                                <td>{{ optional($protocolo->created_at)->format('d-m-Y') }}</td>
                                <td>{{ $protocolo->estado }}</td>
                                <td class="text-right">
                                    <a class="btn btn-sm btn-secondary" href="{{ route('protocolos.edit', $protocolo->id) }}">Gestionar</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">Sin protocolos registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $protocolos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
