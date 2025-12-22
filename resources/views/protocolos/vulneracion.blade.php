<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-orange-800 dark:text-orange-400 leading-tight flex items-center gap-2">
                🛡️ Protocolo de Vulneración de Derechos
            </h2>
            <span class="px-3 py-1 text-sm rounded-full bg-orange-100 text-orange-800 font-bold border border-orange-200">
                Estado: {{ strtoupper($protocolo->estado) }}
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen" x-data="{ openInvolucrado: false, openHechos: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-4 gap-6">

            <div class="lg:col-span-1 space-y-4">
                @if(count($alertas) > 0)
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
                    <h3 class="text-sm font-bold text-red-800 mb-2">⚠️ Alertas Activas</h3>
                    @foreach($alertas as $alerta)
                        <p class="text-xs text-red-700 mb-1">• {{ $alerta['mensaje'] }}</p>
                    @endforeach
                </div>
                @endif

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                    <h3 class="font-bold text-gray-700 dark:text-gray-300 text-sm mb-3">Fases del Protocolo</h3>
                    <ul class="space-y-2 text-xs">
                        <li class="flex justify-between">
                            <span>1. Registro Inicial</span>
                            <span class="{{ $protocolo->involucrados->count() > 0 ? 'text-green-600 font-bold' : 'text-gray-400' }}">
                                {{ $protocolo->involucrados->count() > 0 ? '✔ OK' : 'Pendiente' }}
                            </span>
                        </li>
                        <li class="flex justify-between">
                            <span>2. Notificación Tribunal</span>
                            <span class="{{ $protocolo->denuncia_tribunal ? 'text-green-600 font-bold' : 'text-gray-400' }}">
                                {{ $protocolo->denuncia_tribunal ? '✔ OK' : 'Pendiente' }}
                            </span>
                        </li>
                        </ul>
                </div>
            </div>

            <div class="lg:col-span-3 space-y-6">

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg border-t-4 border-blue-500">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 dark:text-white">👥 Intervinientes</h3>
                        <button @click="openInvolucrado = true" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-3 rounded">
                            + AGREGAR
                        </button>
                    </div>
                    <div class="p-4">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-2 py-2">RUN</th>
                                    <th class="px-2 py-2">Nombre</th>
                                    <th class="px-2 py-2">Rol</th>
                                    <th class="px-2 py-2">Curso</th>
                                    <th class="px-2 py-2">Apoderado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($protocolo->involucrados as $inv)
                                <tr class="border-b">
                                    <td class="px-2 py-2">{{ $inv->rut }}</td>
                                    <td class="px-2 py-2 font-bold">{{ $inv->nombres }} {{ $inv->paterno }}</td>
                                    <td class="px-2 py-2">
                                        <span class="px-2 py-1 rounded text-xs font-bold {{ $inv->rol == 'AFECTADO' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100' }}">
                                            {{ $inv->rol }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-2">{{ $inv->curso }}-{{ $inv->letra }}</td>
                                    <td class="px-2 py-2 text-xs">{{ $inv->nombre_apoderado }}<br><span class="text-blue-500">{{ $inv->telefono_apoderado }}</span></td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-4">No hay registros.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg border-t-4 border-purple-500">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 dark:text-white">📜 Bitácora de Hechos</h3>
                        <button @click="openHechos = true" class="bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold py-2 px-3 rounded">
                            + REGISTRAR
                        </button>
                    </div>
                    <div class="p-4 space-y-4">
                        @forelse($protocolo->hechos as $hecho)
                            <div class="border-l-4 border-purple-200 pl-4">
                                <span class="text-xs font-bold text-gray-500">{{ \Carbon\Carbon::parse($hecho->fecha_inicio)->format('d/m/Y H:i') }}</span>
                                <p class="text-sm italic text-gray-700">"{{ $hecho->relato }}"</p>
                                <div class="mt-1 text-xs text-gray-500">Informante: {{ $hecho->informante_nombre }}</div>
                            </div>
                        @empty
                            <p class="text-center text-sm text-gray-500">Sin hechos registrados.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

        <div x-show="openInvolucrado" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 opacity-75" @click="openInvolucrado = false"></div>
                
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <form action="{{ route('involucrados.store') }}" method="POST" class="p-6">
                        @csrf
                        <input type="hidden" name="protocolo_id" value="{{ $protocolo->id }}">
                        
                        <h3 class="text-lg font-bold mb-4">Nuevo Involucrado</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div><label class="text-xs font-bold">RUN</label><input type="text" name="rut" class="w-full text-sm rounded border-gray-300"></div>
                            <div><label class="text-xs font-bold">Nombres</label><input type="text" name="nombres" class="w-full text-sm rounded border-gray-300" required></div>
                            <div><label class="text-xs font-bold">Paterno</label><input type="text" name="paterno" class="w-full text-sm rounded border-gray-300" required></div>
                            <div><label class="text-xs font-bold">Materno</label><input type="text" name="materno" class="w-full text-sm rounded border-gray-300"></div>
                            
                            <div>
                                <label class="text-xs font-bold">Rol</label>
                                <select name="rol" class="w-full text-sm rounded border-gray-300">
                                    <option value="AFECTADO">Afectado</option>
                                    <option value="AGRESOR">Agresor</option>
                                    <option value="TESTIGO">Testigo</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-bold">Curso</label>
                                <select name="curso" class="w-full text-sm rounded border-gray-300">
                                    <option value="1B">1° Básico</option>
                                    </select>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h4 class="text-sm font-bold mb-2 text-gray-600">Datos Apoderado</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div><label class="text-xs font-bold">Nombre</label><input type="text" name="nombre_apoderado" class="w-full text-sm rounded border-gray-300"></div>
                            <div><label class="text-xs font-bold">Teléfono</label><input type="text" name="telefono_apoderado" class="w-full text-sm rounded border-gray-300"></div>
                            <div><label class="text-xs font-bold">Vínculo</label>
                                <select name="vinculo_apoderado" class="w-full text-sm rounded border-gray-300">
                                    <option value="PADRE">Padre</option>
                                    <option value="MADRE">Madre</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" @click="openInvolucrado = false" class="px-4 py-2 bg-gray-200 rounded text-sm font-bold">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm font-bold">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>