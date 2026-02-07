<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CostFlow') }}</title>

        <link rel="icon" type="image/png" href="{{ asset('icons/money.png') }}">
         {{-- GoogleFonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body x-data="{ sideMenuOpen: false }" class="font-sans antialiased bg-gray-50">
        <div class="flex h-screen overflow-hidden">
            @include('layouts.navigation')

            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <header class="lg:hidden bg-white border-b border-gray-200 p-4 flex items-center justify-end sticky top-0 z-30">
                    <button @click="sideMenuOpen = true">
                        <x-heroicon-o-bars-3 class="w-6 h-6" />
                    </button>
                </header>

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto">
                        {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
