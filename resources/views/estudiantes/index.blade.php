@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            {{-- Botón para volver al Dashboard --}}
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="fa fa-arrow-left"></i> Volver al Dashboard
            </a>
            <h2 style="color: #9ca3af; font-weight: 600;">Listado de Estudiantes</h2>
        </div>
        
        <div class="d-flex gap-2">
            <form action="{{ route('estudiantes.index') }}" method="GET" class="d-flex">
                <div class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control bg-dark text-white border-secondary" 
                           placeholder="Buscar RUT o Nombre..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fa fa-search"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-danger">Limpiar</a>
                    @endif
                </div>
            </form>

            <a href="{{ route('estudiantes.create') }}" class="btn btn-primary ms-3">
                <i class="fa fa-plus"></i> Agregar Nuevo
            </a>
        </div>
    </div>

    {{-- Tabla de Estudiantes --}}
    <div class="card bg-dark text-white border-secondary shadow">
        <div class="card-body">
            <table class="table table-dark table-hover mb-0">
                <thead>
                    <tr style="border-bottom: 2px solid #374151;">
                        <th>RUT</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Curso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($estudiantes as $estudiante)
                    <tr>
                        <td style="color: #60a5fa;">{{ $estudiante->rut }}</td>
                        <td>{{ $estudiante->nombre }}</td>
                        <td>{{ $estudiante->apellido }}</td>
                        <td><span class="badge bg-secondary">{{ $estudiante->curso }}</span></td>
                        <td>
                            <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="fa fa-edit"></i> Editar
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            No se encontraron resultados para "{{ request('search') }}"
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection