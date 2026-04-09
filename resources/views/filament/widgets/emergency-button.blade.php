<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col items-center justify-center space-y-4 py-6 text-center">
            <div class="text-5xl">🚨</div>
            
            <div>
                <h2 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white">
                    PROTOCOLO DE EMERGENCIA CRÍTICA
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Solo para situaciones de riesgo inminente.
                </p>
            </div>
            
            <div class="mt-2">
                {{ $this->triggerAlertAction }}
            </div>
        </div>
    </x-filament::section>

    {{-- 🔥 ESTA ES LA LÍNEA QUE TE FALTA --}}
    <x-filament-actions::modals /> 
</x-filament-widgets::widget>