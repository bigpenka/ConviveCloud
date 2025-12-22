<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-800 dark:text-red-400 leading-tight flex items-center gap-2">
            🚨 Protocolo de Agresión Sexual
            <span class="text-xs bg-red-600 text-white px-2 py-1 rounded-full">CRÍTICO</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-red-100 border-l-4 border-red-600 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">⚠️ {{ $alerta['titulo'] }}</p>
                <p>{{ $alerta['mensaje'] }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-red-600 p-6">
                
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Etapa 1: Denuncias Obligatorias</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="border border-red-200 rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-2xl">👮</span>
                            <h4 class="font-bold text-gray-800 dark:text-gray-200">Carabineros / PDI</h4>
                        </div>
                        <button class="w-full bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700">
                            Registrar Denuncia
                        </button>
                    </div>

                    <div class="border border-red-200 rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-2xl">⚖️</span>
                            <h4 class="font-bold text-gray-800 dark:text-gray-200">Fiscalía</h4>
                        </div>
                        <button class="w-full bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700">
                            Registrar Denuncia
                        </button>
                    </div>

                    <div class="border border-red-200 rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-2xl">🏛️</span>
                            <h4 class="font-bold text-gray-800 dark:text-gray-200">Tribunal Familia</h4>
                        </div>
                        <button class="w-full bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700">
                            Registrar Denuncia
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>