<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.10/dist/tailwind.min.css">
    </head>
    <body class="min-h-screen bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex flex-col items-center lg:justify-center p-6 lg:p-8">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 rounded-sm text-sm leading-normal border border-black bg-[#1b1b18] text-white hover:bg-black hover:border-black dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 rounded-sm text-sm leading-normal border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] dark:text-[#EDEDEC] text-[#1b1b18]">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-block px-5 py-1.5 rounded-sm text-sm leading-normal border border-[#19140035] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:hover:border-[#62605b] dark:text-[#EDEDEC] text-[#1b1b18]">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        <main class="w-full lg:max-w-4xl max-w-[335px] bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0_0_0_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0_0_0_1px_#fffaed2d] rounded-lg p-6 lg:p-12">
            <h1 class="text-lg font-medium mb-2">Welcome</h1>
            <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">
                Laravel has an incredibly rich ecosystem. Explore the documentation and resources to get started.
            </p>
            <div class="flex gap-3">
                <a href="https://laravel.com/docs" target="_blank" class="inline-flex items-center gap-2 font-medium underline underline-offset-4 text-[#f53003] dark:text-[#FF4433]">
                    <span>Documentation</span>
                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5">
                        <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square"/>
                    </svg>
                </a>
                <a href="https://laracasts.com" target="_blank" class="inline-flex items-center gap-2 font-medium underline underline-offset-4 text-[#f53003] dark:text-[#FF4433]">
                    <span>Laracasts</span>
                    <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5">
                        <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square"/>
                    </svg>
                </a>
                <a href="https://cloud.laravel.com" target="_blank" class="inline-block px-5 py-1.5 rounded-sm text-sm leading-normal border border-black bg-[#1b1b18] text-white hover:bg-black hover:border-black dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white">
                    Deploy now
                </a>
            </div>
        </main>
        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
