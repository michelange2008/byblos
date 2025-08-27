<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>

    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">

        </header>
        <div class="flex flex-col gap-10 items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                <div class="flex-1 p-6 pb-12 lg:p-20 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] ">
                    <p class="mb-1 ">Byblos</p>
                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">Partageons nos lectures
                </div>
                <div class="bg-[#fff] dark:bg-[#1D0002] relative flex items-center lg:-ms-px -mb-px lg:mb-0 aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden">
                    <img class="" src="{{ asset('storage/img/babel.jpg') }}" alt="Bibliothèque de Babylone">
                </div>
            </main>
            <div class="mt-10 px-5 py-1.5 border bg-gray-200 text-gray-500 border-gray-200 hover:bg-gray-500 rounded hover:text-white cursor-pointer transition delay-150 ease-in-out">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('books.index') }}">
                            Entrez dans la bibliothèque
                        </a>
                    @else
                        <a href="{{ route('login') }}">
                            Entrez dans la bibliothèque
                        </a>
                    @endauth
                @endif
            </div>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
