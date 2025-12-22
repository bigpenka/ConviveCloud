<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Muestra el Dashboard principal de ConviveCloud.
     * * Se basa en la nueva estructura relacional donde la descripción
     * ya no está en 'protocolos', sino en la tabla 'hechos'.
     */
    public function index()
    {
        try {
            // 1. Estadísticas de la tabla 'protocolos'
            $prot_activos   = DB::table('protocolos')->where('estado', 'Activo')->count();
            $prot_ejecucion = DB::table('protocolos')->where('estado', 'En Ejecución')->count();
            $prot_cerrados  = DB::table('protocolos')->where('estado', 'Cerrado')->count();
            $archivados     = DB::table('protocolos')->where('estado', 'Archivado')->count();

            // 2. Conteo de la tabla 'estudiantes'
            $total_estudiantes = DB::table('estudiantes')->count();

            // 3. Listado de protocolos con JOIN para obtener nombres
            // Usamos leftJoin para que la página cargue aunque no haya datos
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
            // Si hay un error de conexión o falta una tabla, registramos el error y enviamos ceros
            Log::error("Error en Dashboard: " . $e->getMessage());
            
            $prot_activos = 0;
            $prot_ejecucion = 0;
            $prot_cerrados = 0;
            $archivados = 0;
            $total_estudiantes = 0;
            $ultimos_protocolos = collect([]);
        }

        // 4. Enviamos las variables exactas que pide tu Blade Dashboard
        return view('dashboard', compact(
            'prot_activos',
            'prot_ejecucion',
            'prot_cerrados',
            'archivados',
            'total_estudiantes',
            'ultimos_protocolos'
        ));
    }
}