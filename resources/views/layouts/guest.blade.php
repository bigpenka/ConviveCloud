<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-100 antialiased bg-slate-950">
        <div class="min-h-screen flex items-center justify-center px-4 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950"></div>
            <div class="absolute -left-32 -top-24 w-96 h-96 rounded-full bg-indigo-700/10 blur-3xl"></div>
            <div class="absolute -right-24 bottom-0 w-80 h-80 rounded-full bg-emerald-500/10 blur-3xl"></div>

            <div class="relative w-full sm:max-w-md bg-slate-900/80 border border-slate-800 shadow-2xl rounded-2xl px-8 py-8 backdrop-blur">
                <div class="text-center mb-6">
                    <a href="/" class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-700/20 border border-indigo-600/30">
                        <x-application-logo class="w-8 h-8 text-indigo-400 fill-current" />
                    </a>
                    <div class="mt-3 text-lg font-bold text-indigo-100">ConviveCloud</div>
                    <p class="text-sm text-slate-400">Plataforma de gestión de convivencia escolar</p>
                </div>
                <div class="space-y-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
