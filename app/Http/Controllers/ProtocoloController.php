<?php

namespace App\Http\Controllers;

use App\Models\Protocolo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProtocoloController extends Controller
{
    public function index()
    {
        $protocolos = Protocolo::with('estudiante')->latest()->paginate(10);
        return view('protocolos.index', compact('protocolos'));
    }

    public function edit($id)
    {
        $protocolo = Protocolo::with('estudiante')->findOrFail($id);

        $fechaAct    = $protocolo->fecha_activacion ?: '';
        $fechaCierre = $protocolo->fecha_cierre ?: '';

        if ((int)$protocolo->tipo_id === 2) {
            // Done para agresión sexual (solo filas válidas)
            $done = [
                'pre' => DB::table('protocolos_as_informes')
                            ->where('protocolo_id',$protocolo->id)->where('etapa','pre')->exists()
                         || (!empty($protocolo->as_pre_lesiones) && !empty($protocolo->as_pre_observaciones)),
                'e1'  => DB::table('protocolos_as_medidas')->where('protocolo_id',$protocolo->id)->exists()
                         || !empty($protocolo->as_e1_notas),
               'e2' => DB::table('protocolos_as_diligencias')
    ->where('protocolo_id', $protocolo->id)
    ->whereNotNull('tipo')
    ->whereRaw("TRIM(tipo) <> ''")
    ->whereNotNull('descripcion')
    ->whereRaw("TRIM(descripcion) <> ''")
    ->whereNotNull('fecha')
    ->whereRaw("fecha <> ''")
    ->exists(),

                'e3'  => !empty($protocolo->as_e3_conclusiones),
                'e45' => !empty($protocolo->as_e4_5_notas),
                'e6'  => DB::table('protocolos_as_citas')->where('protocolo_id',$protocolo->id)->exists()
                         || !empty($protocolo->as_e6_notas),
                'e7'  => !empty($protocolo->as_e7_detalle_final) && !empty($protocolo->as_e7_fecha_cierre),
            ];
            $partial = 'protocolos.partials.etapas_agresion';
        } else {
    // Done para vulneración - Cambiamos v1 por 1, v2 por 2, etc.
    $obsLower = strtolower($protocolo->observacion_cierre ?? '');
    $done = [
        1 => !empty($protocolo->estado) && !empty($protocolo->fecha_activacion),
        2 => (bool) ($protocolo->entrevista_realizada ?? false),
        3 => (bool) ($protocolo->denuncia_policia ?? false)
             || (bool) ($protocolo->denuncia_fiscalia ?? false)
             || (bool) ($protocolo->denuncia_tribunal ?? false),
        4 => str_contains($obsLower, 'reuni'),
        5 => str_contains($obsLower, 'plan:'),
        6 => !empty($protocolo->fecha_cierre),
        7 => ($protocolo->estado ?? '') === 'Cerrado',
    ];
    $partial = 'protocolos.partials.etapas_vulneracion';
}

        return view('protocolos.edit', compact('protocolo','fechaAct','fechaCierre','done','partial'));
    }

    public function update(Request $request, $id)
    {
        $protocolo = Protocolo::findOrFail($id);
        $mensaje = null;

        // Detecta etapa; hotfix para AS E2 si no llega hidden
        $etapa = $request->input('etapa');
        if ((int)$protocolo->tipo_id === 2 && !$etapa) {
            if (
                $request->has('as_e2_tipo') ||
                $request->has('as_e2_desc') ||
                $request->has('as_e2_fecha') ||
                $request->hasFile('as_e2_adjunto')
            ) {
                $etapa = 'as_e2';
            }
        }

        if ((int)$protocolo->tipo_id === 2) {
            // Agresión sexual
            switch ($etapa) {
                case 'as_pre':
                    if (!$request->filled('as_pre_lesiones') || !$request->filled('as_pre_observaciones')) {
                        return back()->with('error','Completa lesiones y observaciones en preliminar.');
                    }
                    $protocolo->as_pre_lesiones      = $request->input('as_pre_lesiones');
                    $protocolo->as_pre_observaciones = $request->input('as_pre_observaciones');
                    if ($request->hasFile('as_pre_comprobante')) {
                        $path = $request->file('as_pre_comprobante')->store('as_informes');
                        DB::table('protocolos_as_informes')->insert([
                            'protocolo_id'=>$protocolo->id,'etapa'=>'pre','archivo'=>$path,'created_at'=>now(),
                        ]);
                    }
                    $mensaje = 'Etapa preliminar finalizada con éxito.';
                    break;

                case 'as_e1':
                    if (!$request->filled('as_e1_notas')) {
                        return back()->with('error','Ingresa notas/medidas en etapa 1.');
                    }
                    $protocolo->as_e1_notificacion_auto = $request->boolean('as_e1_notificacion_auto') ? 1 : 0;
                    $protocolo->as_e1_notas             = $request->input('as_e1_notas');
                    DB::table('protocolos_as_medidas')->where('protocolo_id',$protocolo->id)->delete();
                    $medidas = $request->input('as_e1_medidas', []);
                    foreach ($medidas as $m) {
                        if (!empty($m['medida'])) {
                            DB::table('protocolos_as_medidas')->insert([
                                'protocolo_id'=>$protocolo->id,'medida'=>$m['medida'],'detalle'=>$m['detalle'] ?? null,
                            ]);
                        }
                    }
                    $mensaje = 'Etapa 1 finalizada con éxito.';
                    break;

                case 'as_e2':
                    if (
                        !$request->filled('as_e2_tipo') ||
                        !$request->filled('as_e2_desc') ||
                        !$request->filled('as_e2_fecha')
                    ) {
                        return back()->with('error','Completa tipo, descripción y fecha para la Etapa 2.');
                    }
                    $adj = null;
                    if ($request->hasFile('as_e2_adjunto')) {
                        $adj = $request->file('as_e2_adjunto')->store('as_diligencias');
                    }
                    DB::table('protocolos_as_diligencias')->insert([
                        'protocolo_id'=>$protocolo->id,
                        'tipo'=>$request->input('as_e2_tipo'),
                        'descripcion'=>$request->input('as_e2_desc'),
                        'fecha'=>$request->input('as_e2_fecha'),
                        'adjunto'=>$adj,
                    ]);
                    $mensaje = 'Etapa 2 finalizada con éxito.';
                    break;

                case 'as_e3':
                    if (!$request->filled('as_e3_conclusiones')) {
                        return back()->with('error','Ingresa conclusiones en etapa 3.');
                    }
                    $protocolo->as_e3_enviar_eq    = $request->boolean('as_e3_enviar_eq') ? 1 : 0;
                    $protocolo->as_e3_conclusiones = $request->input('as_e3_conclusiones');
                    if ($request->hasFile('as_e3_archivo')) {
                        $path = $request->file('as_e3_archivo')->store('as_informes');
                        DB::table('protocolos_as_informes')->insert([
                            'protocolo_id'=>$protocolo->id,'etapa'=>'e3','archivo'=>$path,
                            'notas'=>$request->input('as_e3_conclusiones'),'created_at'=>now(),
                        ]);
                    }
                    $mensaje = 'Etapa 3 finalizada con éxito.';
                    break;

                case 'as_e4_5':
                    if (!$request->filled('as_e4_5_notas')) {
                        return back()->with('error','Ingresa notas para la etapa 4/5.');
                    }
                    $protocolo->as_e4_5_notificar = $request->boolean('as_e4_5_notificar') ? 1 : 0;
                    $protocolo->as_e4_5_notas     = $request->input('as_e4_5_notas');
                    if ($request->hasFile('as_e4_5_archivo')) {
                        $path = $request->file('as_e4_5_archivo')->store('as_informes');
                        DB::table('protocolos_as_informes')->insert([
                            'protocolo_id'=>$protocolo->id,'etapa'=>'e4_5','archivo'=>$path,
                            'notas'=>$request->input('as_e4_5_notas'),'created_at'=>now(),
                        ]);
                    }
                    $mensaje = 'Etapa 4/5 finalizada con éxito.';
                    break;

                case 'as_e6':
                    if (
                        !$request->filled('as_e6_notas') &&
                        !$request->filled('as_e6_cita_fecha') &&
                        !$request->filled('as_e6_cita_nota')
                    ) {
                        return back()->with('error','Agrega notas o una cita para la etapa 6.');
                    }
                    $protocolo->as_e6_notas = $request->input('as_e6_notas');
                    if ($request->filled('as_e6_cita_fecha') || $request->filled('as_e6_cita_nota')) {
                        DB::table('protocolos_as_citas')->insert([
                            'protocolo_id'=>$protocolo->id,
                            'fecha'=>$request->input('as_e6_cita_fecha'),
                            'nota'=>$request->input('as_e6_cita_nota'),
                        ]);
                    }
                    $mensaje = 'Etapa 6 finalizada con éxito.';
                    break;

                case 'as_e7':
                    if (!$request->filled('as_e7_detalle_final') || !$request->filled('as_e7_fecha_cierre')) {
                        return back()->with('error','Ingresa detalle final y fecha de cierre en etapa 7.');
                    }
                    $protocolo->as_e7_detalle_final = $request->input('as_e7_detalle_final');
                    $protocolo->as_e7_fecha_cierre  = $request->input('as_e7_fecha_cierre');
                    $protocolo->as_e7_firma_digital = $request->boolean('as_e7_firma_digital') ? 1 : 0;
                    if ($request->hasFile('as_e7_certificado')) {
                        $path = $request->file('as_e7_certificado')->store('as_informes');
                        DB::table('protocolos_as_informes')->insert([
                            'protocolo_id'=>$protocolo->id,'etapa'=>'e7','archivo'=>$path,
                            'notas'=>$request->input('as_e7_detalle_final'),'created_at'=>now(),
                        ]);
                    }
                    if ($request->filled('estado')) {
                        $protocolo->estado = $request->input('estado');
                    }
                    $mensaje = 'Etapa 7 finalizada con éxito.';
                    break;

                default:
                    $mensaje = 'Protocolo actualizado.';
                    break;
            }

            $protocolo->save();
            return redirect()->route('protocolos.edit', $protocolo->id)
                ->with('success', $mensaje ?? 'Protocolo actualizado.');
        }

        // Vulneración
        switch ($request->input('etapa')) {
            case 1:
                if (!$request->filled('estado') || !$request->filled('fecha_activacion')) {
                    return back()->with('error','Completa estado y fecha de activación en etapa 1.');
                }
                $protocolo->estado           = $request->input('estado');
                $protocolo->fecha_activacion = $request->input('fecha_activacion');
                $mensaje = 'Etapa 1 finalizada con éxito.';
                break;

            case 2:
                if (!$request->has('entrevista_realizada')) {
                    return back()->with('error','Debes marcar entrevista realizada en etapa 2.');
                }
                $protocolo->entrevista_realizada = $request->boolean('entrevista_realizada') ? 1 : 0;
                $mensaje = 'Etapa 2 finalizada con éxito.';
                break;

            case 3:
                if (
                    !$request->boolean('denuncia_policia') &&
                    !$request->boolean('denuncia_fiscalia') &&
                    !$request->boolean('denuncia_tribunal') &&
                    !$request->filled('observacion_cierre')
                ) {
                    return back()->with('error','Marca al menos una denuncia o agrega observación en etapa 3.');
                }
                $protocolo->denuncia_policia   = $request->boolean('denuncia_policia') ? 1 : 0;
                $protocolo->denuncia_fiscalia  = $request->boolean('denuncia_fiscalia') ? 1 : 0;
                $protocolo->denuncia_tribunal  = $request->boolean('denuncia_tribunal') ? 1 : 0;
                $protocolo->observacion_cierre = $request->input('observacion_cierre');
                $mensaje = 'Etapa 3 finalizada con éxito.';
                break;

            case 7:
                if (!$request->filled('det_final') || !$request->filled('et7_fecha')) {
                    return back()->with('error','Ingresa detalle final y fecha de cierre en etapa 7.');
                }
                $protocolo->estado             = $request->input('estado', $protocolo->estado);
                $protocolo->fecha_cierre       = $request->input('et7_fecha', $protocolo->fecha_cierre);
                $protocolo->observacion_cierre = $request->input('det_final', $protocolo->observacion_cierre);
                $mensaje = 'Etapa 7 finalizada con éxito.';
                break;

            default:
                $mensaje = 'Protocolo actualizado.';
                break;
        }

        $protocolo->save();
        return redirect()->route('protocolos.edit', $protocolo->id)
            ->with('success', $mensaje ?? 'Protocolo actualizado.');
    }

    public function destroy(Protocolo $protocolo)
    {
        $protocolo->delete();
        return back()->with('success', 'Protocolo eliminado.');
    }
    public function create(Request $request)
{
    // Capturamos el tipo (vulneracion o agresion) desde la URL
    $tipo = $request->query('tipo', 'vulneracion');
    
    // Obtenemos los estudiantes para el selector del formulario
    $estudiantes = \App\Models\Estudiante::all();

    return view('protocolos.create', compact('tipo', 'estudiantes'));
}
public function store(Request $request)
{
    // Validamos que se haya seleccionado un estudiante
    $request->validate([
        'estudiante_id' => 'required|exists:estudiantes,id',
        'tipo' => 'required|string'
    ]);

    // Creamos el protocolo con los datos iniciales
    $protocolo = Protocolo::create([
        'folio' => 'PROT-' . strtoupper(uniqid()), // Genera un folio único
        'estudiante_id' => $request->estudiante_id,
        'tipo' => $request->tipo,
        'estado' => 'Activo',
        'fecha_activacion' => now(), // Registra la activación de inmediato 
    ]);

    // Redirigimos según el tipo de protocolo para continuar con las etapas
    if ($request->tipo === 'agresion-sexual') {
        return redirect()->route('protocolos.agresion', $protocolo->id)
                         ->with('success', 'Protocolo de Agresión Sexual activado correctamente.');
    }

    return redirect()->route('dashboard')->with('success', 'Protocolo de Vulneración activado.');
}

}

