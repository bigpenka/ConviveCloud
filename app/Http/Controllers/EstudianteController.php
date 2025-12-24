<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    /**
     * Muestra la lista de estudiantes registrados.
     */
public function index(Request $request)
{
    // 1. Obtenemos el texto que el usuario escribió en el buscador
    $search = $request->input('search');

    // 2. Iniciamos la consulta
    $query = Estudiante::query();

    // 3. Si hay algo escrito, filtramos por RUT, Nombre o Apellido
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('rut', 'LIKE', "%{$search}%")
              ->orWhere('nombre', 'LIKE', "%{$search}%")
              ->orWhere('apellido', 'LIKE', "%{$search}%")
              ->orWhere('curso', 'LIKE', "%{$search}%");
        });
    }

    // 4. Obtenemos los resultados (puedes usar paginate(10) si tienes muchos)
    $estudiantes = $query->orderBy('apellido', 'asc')->get();

    // 5. Enviamos los datos a la vista
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