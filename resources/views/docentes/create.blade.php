@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('docentes.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Volver al Listado
        </a>
    </div>

    <div class="card bg-dark text-white border-secondary shadow-lg" style="max-width: 600px; margin: auto;">
        <div class="card-header border-secondary bg-dark">
            <h4 class="mb-0"><i class="fa fa-user-plus text-info"></i> Registrar Nuevo Docente</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('docentes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-muted">RUT (con puntos y guion)</label>
                    <input type="text" name="rut" class="form-control bg-dark text-white border-secondary" required placeholder="12.345.678-9">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Nombre</label>
                        <input type="text" name="nombre" class="form-control bg-dark text-white border-secondary" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Apellido</label>
                        <input type="text" name="apellido" class="form-control bg-dark text-white border-secondary" required>
                    </div>
                </div>

                {{-- Campo modificado: Especialidad / Cargo como Selector --}}
                <div class="mb-3">
                    <label class="form-label text-muted">Especialidad / Cargo Oficial</label>
                    <select name="especialidad" class="form-select bg-dark text-white border-secondary" required>
                        <option value="" selected disabled>Seleccione un cargo...</option>
                        <optgroup label="Directivos">
                            <option value="Director/a">Director/a</option>
                            <option value="Inspector/a General">Inspector/a General</option>
                            <option value="Jefe/a de UTP">Jefe/a de UTP</option>
                        </optgroup>
                        <optgroup label="Equipo de Convivencia">
                            <option value="Encargado/a de Convivencia">Encargado/a de Convivencia</option>
                            <option value="Psicólogo/a">Psicólogo/a</option>
                            <option value="Orientador/a">Orientador/a</option>
                            <option value="Trabajador/a Social">Trabajador/a Social</option>
                        </optgroup>
                        <optgroup label="Docentes y Asistentes">
                            <option value="Profesor/a Jefe">Profesor/a Jefe</option>
                            <option value="Profesor/a de Asignatura">Profesor/a de Asignatura</option>
                            <option value="Educador/a Diferencial">Educador/a Diferencial</option>
                            <option value="Asistente de la Educación">Asistente de la Educación</option>
                            <option value="Inspector/a de Patio">Inspector/a de Patio</option>
                        </optgroup>
                    </select>
                    
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control bg-dark text-white border-secondary" required placeholder="usuario@convivecloud.local">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary fw-bold">Guardar Docente</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection