@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card" style="background-color: #1f2937; color: white; border: 1px solid #374151; border-radius: 10px;">
                <div class="card-header border-bottom border-secondary">
                    <h3 class="card-title"><i class="fa fa-user-plus"></i> Registrar Nuevo Estudiante</h3>
                </div>
                <form action="{{ route('estudiantes.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>RUT (Ej: 12.345.678-9)</label>
                                <input type="text" name="rut" class="form-control" style="background-color: #111827; border: 1px solid #4b5563; color: white;" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Curso</label>
                                <select name="curso" class="form-control" style="background-color: #111827; border: 1px solid #4b5563; color: white;" required>
                                    <option value="" disabled selected>Seleccione un curso...</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso }}">{{ $curso }}</option>
                                    @endforeach
                                </select>
                                @error('curso')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nombres</label>
                                <input type="text" name="nombre" class="form-control" style="background-color: #111827; border: 1px solid #4b5563; color: white;" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Apellidos</label>
                                <input type="text" name="apellido" class="form-control" style="background-color: #111827; border: 1px solid #4b5563; color: white;" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right border-top border-secondary">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary" style="background-color: #2563eb; border: none;">GUARDAR ESTUDIANTE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection