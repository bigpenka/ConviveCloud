<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // 1. Estadísticas de protocolos
            $prot_activos   = DB::table('protocolos')->where('estado', 'Activo')->count();
            $prot_ejecucion = DB::table('protocolos')->where('estado', 'En Ejecución')->count();
            $prot_cerrados  = DB::table('protocolos')->where('estado', 'Cerrado')->count();
            $archivados     = DB::table('protocolos')->where('estado', 'Archivado')->count();

            // 2. Conteos de poblaciones (Estudiantes y Docentes)
            $total_estudiantes = DB::table('estudiantes')->count();
            $total_docentes    = DB::table('docentes')->count(); // <--- LÍNEA NUEVA

            // 3. Listado de protocolos con JOIN
            $ultimos_protocolos = DB::table('protocolos')
                ->leftJoin('estudiantes', 'protocolos.estudiante_id', '=', 'estudiantes.id')
                ->select(
                    'protocolos.id',
                    'protocolos.folio',
                    'protocolos.tipo',
                    'protocolos.estado',
                    'protocolos.created_at',
                    DB::raw("CONCAT(estudiantes.nombre, ' ', estudiantes.apellido) as estudiante_nombre")
                )
                ->orderBy('protocolos.created_at', 'desc')
                ->take(5)
                ->get();

        } catch (\Exception $e) {
            Log::error("Error en Dashboard: " . $e->getMessage());
            
            $prot_activos = 0;
            $prot_ejecucion = 0;
            $prot_cerrados = 0;
            $archivados = 0;
            $total_estudiantes = 0;
            $total_docentes = 0; // <--- INICIALIZAR EN CERO
            $ultimos_protocolos = collect([]);
        }

        // 4. Enviamos las variables (Asegúrate de incluir 'total_docentes')
        return view('dashboard', compact(
            'prot_activos',
            'prot_ejecucion',
            'prot_cerrados',
            'archivados',
            'total_estudiantes',
            'total_docentes', // <--- ENVIAR A LA VISTA
            'ultimos_protocolos'
        ));
    }
}
