<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? config('app.name', 'Player Notes') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
                body { font-family: 'Instrument Sans', sans-serif; background: #FDFDFC; color: #1b1b18; }
            </style>
        @endif

        @livewireStyles
    </head>
    <body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
        <div class="max-w-4xl mx-auto py-8 px-4">
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
