<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    /**
     * Muestra la lista de estudiantes registrados.
     */
    public function index()
    {
        $estudiantes = Estudiante::all();
        return view('estudiantes.index', compact('estudiantes'));
    }

    /**
     * Muestra el formulario de creación con el listado de cursos para el selector.
     */
    public function create()
    {
        $cursos = $this->getCursos();
        return view('estudiantes.create', compact('cursos'));
    }

    /**
     * Guarda el estudiante en la base de datos siguiendo la nueva estructura.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rut'      => 'required|unique:estudiantes,rut',
            'nombre'   => 'required',
            'apellido' => 'required',
            'curso'    => 'required',
        ]);

        // Guardamos los datos en la tabla 'estudiantes'
        Estudiante::create($request->all());

        return redirect()->route('dashboard')->with('success', 'Estudiante registrado correctamente');
    }

    /**
     * Listado centralizado de cursos para ConviveCloud.
     */
    private function getCursos()
    {
        return [
            '1° Básico A', '1° Básico B',
            '2° Básico A', '2° Básico B',
            '3° Básico A', '3° Básico B',
            '4° Básico A', '4° Básico B',
            '5° Básico A', '5° Básico B',
            '6° Básico A', '6° Básico B',
            '7° Básico A', '7° Básico B',
            '8° Básico A', '8° Básico B',
            'I° Medio A',  'I° Medio B',
            'II° Medio A', 'II° Medio B',
            'III° Medio A', 'III° Medio B',
            'IV° Medio A', 'IV° Medio B',
        ];
    }
}