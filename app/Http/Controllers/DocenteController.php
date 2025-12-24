<?php

namespace App\Http\Controllers;

use App\Models\Docente; // Importamos el modelo
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    /**
     * Muestra el listado de docentes con opción de búsqueda.
     */
    public function index(Request $request)
    {
        // 1. Capturamos lo que el usuario escribe en el buscador de la vista
        $search = $request->input('search');

        // 2. Iniciamos la consulta a la tabla 'docentes'
        $query = Docente::query();

        // 3. Si hay búsqueda, filtramos por Nombre, Apellido, RUT o Especialidad
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('apellido', 'LIKE', "%{$search}%")
                  ->orWhere('rut', 'LIKE', "%{$search}%")
                  ->orWhere('especialidad', 'LIKE', "%{$search}%");
            });
        }

        // 4. Obtenemos los resultados ordenados por apellido
        $docentes = $query->orderBy('apellido', 'asc')->get();

        // 5. Retornamos la vista que creaste pasando la variable $docentes
        return view('docentes.index', compact('docentes'));
    }
    

    // Puedes dejar los otros métodos (create, store, edit) vacíos por ahora
    public function create() { return view('docentes.create'); }
    public function store(Request $request)
{
    $request->validate([
        'rut' => 'required|unique:docentes,rut',
        'nombre' => 'required',
        'apellido' => 'required',
        'email' => 'required|email|unique:docentes,email'
    ]);

    \App\Models\Docente::create($request->all());

    return redirect()->route('docentes.index')->with('success', 'Docente registrado correctamente.');
}
    public function edit($id) { return view('docentes.edit', compact('id')); }
    
}