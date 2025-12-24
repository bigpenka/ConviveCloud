@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Encabezado con Navegación y Buscador --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm mb-2 shadow-sm">
                <i class="fa fa-arrow-left"></i> Volver al Dashboard
            </a>
            <h2 style="color: #9ca3af; font-weight: 600;">Gestión de Docentes</h2>
        </div>
        
        <div class="d-flex gap-2">
            {{-- Buscador Funcional --}}
            <form action="{{ route('docentes.index') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-dark text-white border-secondary" 
                           placeholder="Buscar por RUT o Nombre..." value="{{ request('search') }}"
                           style="min-width: 280px;">
                    <button type="submit" class="btn btn-secondary border-secondary">
                        <i class="fa fa-search"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('docentes.index') }}" class="btn btn-outline-danger border-secondary">
                            <i class="fa fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
            
            <a href="{{ route('docentes.create') }}" class="btn btn-primary ms-2 shadow-sm">
                <i class="fa fa-user-plus"></i> Agregar Docente
            </a>
        </div>
    </div>

    {{-- Tabla de Resultados --}}
    <div class="card bg-dark text-white border-secondary shadow-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead class="border-secondary">
                        <tr style="color: #9ca3af; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.05em;">
                            <th class="px-4 py-3">RUT</th>
                            <th class="py-3">Nombre Completo</th>
                            <th class="py-3">Especialidad / Cargo</th>
                            <th class="py-3">Correo Institucional</th>
                            <th class="py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="border-secondary">
                        @forelse($docentes as $docente)
                        <tr class="align-middle">
                            <td class="px-4 py-3 font-monospace" style="color: #60a5fa;">{{ $docente->rut }}</td>
                            <td class="py-3 fw-bold">{{ $docente->nombre }} {{ $docente->apellido }}</td>
                            <td class="py-3">
                                <span class="badge border border-info text-info">{{ $docente->especialidad ?? 'No asignada' }}</span>
                            </td>
                            <td class="py-3 text-muted">{{ $docente->email }}</td>
                            <td class="py-3 text-center">
                                <div class="btn-group">
                                    <a href="{{ route('docentes.edit', $docente->id) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fa fa-edit"></i> Editar
                                    </a>
                                    {{-- Acción rápida para citar a entrevista en Etapa 2 --}}
                                    <button class="btn btn-sm btn-outline-secondary ms-1" title="Citar como testigo">
                                        <i class="fa fa-calendar-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa fa-users-slash fa-3x mb-3"></i>
                                <p class="mb-0">No se encontraron docentes registrados que coincidan con "{{ request('search') }}".</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Footer Informativo --}}
    <div class="mt-4 text-end">
        <small class="text-muted">Mostrando {{ $docentes->count() }} docentes registrados en el sistema.</small>
    </div>
</div>
@endsection