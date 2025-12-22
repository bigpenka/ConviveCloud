<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Protocolo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProtocoloController extends Controller
{
    public function index()
    {
        $protocolos = Protocolo::with('estudiante')
            ->latest()
            ->paginate(10);

        return view('protocolos.index', compact('protocolos'));
    }

    public function create(Request $request)
    {
        $estudiantes = Estudiante::all();
        $tipo = $request->query('tipo', 'vulneracion');

        return view('protocolos.create', compact('estudiantes', 'tipo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'tipo'          => 'required',
        ]);

        $ultimoId = Protocolo::max('id') + 1;
        $folio = 'PROT-' . date('Y') . '-' . str_pad($ultimoId ?? 1, 3, '0', STR_PAD_LEFT);

        Protocolo::create([
            'folio'              => $folio,
            'tipo'               => $request->tipo,
            'estado'             => 'Activo',
            'estudiante_id'      => $request->estudiante_id,
            'user_id'            => Auth::id(),
            'fecha_activacion'   => now(),
            'fecha_cierre'       => null,
            'observacion_cierre' => null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Protocolo iniciado correctamente.');
    }

    // Redirige show -> edit para no duplicar vista
    public function show(Protocolo $protocolo)
    {
        return redirect()->route('protocolos.edit', $protocolo);
    }

    public function edit(Protocolo $protocolo)
    {
        $protocolo->load('estudiante');
        $estudiantes = Estudiante::all();

        return view('protocolos.edit', compact('protocolo', 'estudiantes'));
    }

public function update(Request $request, Protocolo $protocolo)
{
    $etapa = $request->input('etapa'); // 1..7

    switch ($etapa) {
        case '1':
            $protocolo->estado = 'En Ejecucion';
            $protocolo->fecha_activacion = $request->input('fecha_activacion') ?: now();
            break;

        case '2':
            // Marca entrevista como realizada
            $protocolo->entrevista_realizada = true;
            $resumen = $request->input('et2_resumen');
            $fecha = $request->input('et2_fecha_hecho');
            $hora  = $request->input('et2_hora_hecho');
            $protocolo->observacion_cierre = trim(($protocolo->observacion_cierre ?? '')."\nHecho: $fecha $hora\n$resumen");
            break;

        case '3':
    // Policia siempre visible
    $protocolo->denuncia_policia = $request->boolean('denuncia_policia');

    // ¿Es delito?
    $esDelito = $request->input('et3_delito'); // ajusta si en el form usas otro name (ej: es_delito)

    if ($esDelito === 'si') {
        // Si es agresión sexual, permite marcar Fiscalía y Tribunal
        if (strtolower($protocolo->tipo ?? '') === 'agresion sexual') {
            $protocolo->denuncia_fiscalia = $request->boolean('denuncia_fiscalia');
            $protocolo->denuncia_tribunal = $request->boolean('denuncia_tribunal');
        } else {
            // Otros tipos: no usar Fiscalía/Tribunal
            $protocolo->denuncia_fiscalia = false;
            $protocolo->denuncia_tribunal = false;
        }
    } else {
        // No es delito: limpiar flags y registrar sanción
        $protocolo->denuncia_fiscalia = false;
        $protocolo->denuncia_tribunal = false;

        $sancion = $request->input('et3_sancion');
        $dias    = $request->input('et3_dias');
        $motivo  = $request->input('et3_motivo');
        $protocolo->observacion_cierre = trim(($protocolo->observacion_cierre ?? '')."\nSanción: $sancion ($dias días) Motivo: $motivo");
    }
    break;

        case '4':
            $v  = $request->input('et4_reu_victima');
            $av = $request->input('et4_mod_victima');
            $a  = $request->input('et4_reu_agresor');
            $aa = $request->input('et4_mod_agresor');
            $protocolo->observacion_cierre = trim(($protocolo->observacion_cierre ?? '')."\nReunión víctima: $v ($av)\nReunión agresor: $a ($aa)");
            break;

        case '5':
            $protocolo->estado = 'En Ejecucion';
            $plan = $request->input('et5_plan');
            $psic = $request->input('et5_psico');
            $protocolo->observacion_cierre = trim(($protocolo->observacion_cierre ?? '')."\nPlan: $plan | Psicólogo: $psic");
            break;

        case '6':
            $notas = $request->input('et6_notas');
            $protocolo->observacion_cierre = trim(($protocolo->observacion_cierre ?? '')."\nInforme cierre: $notas");
            break;

        case '7':
            $protocolo->estado = 'Cerrado';
            $protocolo->fecha_cierre = $request->input('et7_fecha') ?: now();
            $protocolo->observacion_cierre = $request->input('det_final');
            $protocolo->save();
            return redirect()->route('dashboard')->with('success','Protocolo cerrado.');
    }

    // Flags comunes
    $protocolo->entrevista_realizada = $request->boolean('entrevista_realizada', $protocolo->entrevista_realizada);
    $protocolo->denuncia_fiscalia    = $request->boolean('denuncia_fiscalia', $protocolo->denuncia_fiscalia);
    $protocolo->denuncia_tribunal    = $request->boolean('denuncia_tribunal', $protocolo->denuncia_tribunal);

    if ($protocolo->estado === 'Archivado' && !$protocolo->fecha_cierre) {
        $protocolo->fecha_cierre = now();
    }

    $protocolo->save();
    return back()->with('success','Protocolo actualizado.');
}


    public function destroy(Protocolo $protocolo)
    {
        $protocolo->delete();

        return redirect()->route('protocolos.index')->with('success', 'Protocolo eliminado.');
    }
}
