<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <img id="background" class="fixed top-0 left-0 w-full h-full opacity-40" src="{{ Vite::asset('resources/images/colorful-geometry-shapes-830.jpg') }}" alt="Laravel background" />
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <form method="post" action="." class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    @csrf
                    <header class="grid items-center grid-cols-2 gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            <button type="submit" class="px-4 py-2 text-3xl font-bold transition duration-300 rounded-md hover:bg-white/70 dark:hover:bg-black/70 hover:text-black/70 dark:hover:text-white/70">QR</button>
                        </div>
                    </header>

                    <main class="mt-6">
                        <div class="grid gap-6 lg:grid-flow-col lg:grid-rows-3 lg:gap-8">
                            <div class="flex items-center justify-between gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20] formField">
                                <label for="linkToConvert inline-block w-20">@lang('Link')</label>
                                <input type="text" name="linkToConvert" id="linkToConvert"
                                    value="{{ $link ?? null }}"
                                    class="w-3/4 px-2 py-1 bg-white rounded-md text-black/70" autofocus />
                            </div>

                            <div class="flex items-center justify-between gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20] formField">
                                <label for="qrColor">@lang('Color')</label>
                                <input type="color" name="qrColor" id="qrColor"
                                    value="{{ $color ?? null }}"
                                    class="w-3/4 px-1 bg-white rounded-md text-black/70" />
                            </div>

                            <div class="flex items-center justify-between gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20] formField">
                                <label for="qrType">@lang('Estilo')</label>
                                <select name="qrType" id="qrType" class="w-3/4 px-2 py-1 bg-white rounded-md text-black/70">
                                    <option value="square" @selected(($style ?? null) === 'square')>@lang('Cuadrados')</option>
                                    <option value="round" @selected(($style ?? null) === 'round')>@lang('Redondeado')</option>
                                    <option value="dot" @selected(($style ?? null) === 'dot')>@lang('Puntos')</option>
                                </select>
                            </div>

                            <div id="qrContainer" class="relative flex flex-col justify-center items-center gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                                @if ($qr ?? false)
                                    <div>
                                        @if ($png ?? false)
                                            <img src="data:image/png;base64,{!! base64_encode($qr) !!}" />
                                        @else
                                            {!! $qr !!}
                                        @endif
                                    </div>
                                    <a href="{{ $link }}" target="_blank" rel="noopener noreferrer"
                                        class="w-full text-center truncate cursor-pointer"
                                        title="{{ $link }}"
                                    >
                                        {{ $link }}
                                    </a>
                                    @if ($png ?? false)
                                        <x-badge-blue class="absolute block cursor-default top-2 right-2">PNG</x-badge-blue>
                                    @else
                                        <x-badge-yellow class="absolute block cursor-default top-2 right-2">SVG</x-badge-yellow>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </main>
                </form>
            </div>
        </div>
    </body>
</html>
