@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card" style="background-color: #1f2937; color: white; border: 1px solid #dc2626;">
                <div class="card-header">
                    <h3 class="card-title">Iniciar Protocolo: {{ ucfirst(str_replace('_', ' ', $tipo)) }}</h3>
                </div>
                <form action="{{ route('protocolos.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tipo" value="{{ $tipo }}">
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <label>Seleccionar Estudiante Involucrado</label>
                            <select name="estudiante_id" class="form-control" style="background-color: #111827; color: white; border: 1px solid #4b5563;" required>
                                <option value="">-- Buscar Estudiante --</option>
                                @foreach($estudiantes as $estudiante)
                                    <option value="{{ $estudiante->id }}">{{ $estudiante->rut }} - {{ $estudiante->nombre }} {{ $estudiante->apellido }}</option>
                                @endforeach
                            </select>
                        </div>
                        <p class="text-muted small">Al iniciar, se generará un folio único y el estado quedará como "Activo".</p>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-danger">CONFIRMAR INICIO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection