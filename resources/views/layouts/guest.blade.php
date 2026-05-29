<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Au-dela des faits') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="relative min-h-screen overflow-hidden bg-slate-950">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_12%_12%,rgba(59,130,246,.34),transparent_28rem),radial-gradient(circle_at_86%_18%,rgba(245,158,11,.2),transparent_24rem),linear-gradient(135deg,#020617,#0f172a_58%,#1e3a8a)]"></div>
            <div class="absolute left-[-5rem] top-24 h-72 w-72 rounded-full border border-amber-300/20"></div>
            <div class="absolute bottom-[-7rem] right-[-4rem] h-96 w-96 rounded-full border border-sky-300/20"></div>
            <div class="absolute inset-0 bg-[linear-gradient(115deg,transparent_0_34%,rgba(255,255,255,.08)_34%_34.4%,transparent_34.4%),linear-gradient(65deg,transparent_0_62%,rgba(245,158,11,.14)_62%_62.4%,transparent_62.4%)]"></div>

            <div class="relative z-10 grid min-h-screen lg:grid-cols-[1fr_520px]">
                <section class="hidden px-12 py-10 text-white lg:flex lg:flex-col lg:justify-between">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.PNG') }}" alt="Logo Au-dela des faits" class="h-12 w-12 rounded-2xl object-cover shadow-2xl">
                        <span class="text-xl font-extrabold">Au-dela des faits</span>
                    </a>

                    <div class="max-w-2xl">
                        <p class="text-sm font-bold uppercase tracking-[0.28em] text-amber-300">Espace administration</p>
                        <h1 class="mt-4 text-5xl font-extrabold leading-tight">
                            Pilotez vos contenus avec une interface claire et premium.
                        </h1>
                        <p class="mt-5 max-w-xl text-lg leading-8 text-slate-300">
                            Publiez les articles, organisez les medias, moderez les commentaires et suivez les statistiques depuis un espace concu pour travailler vite et bien.
                        </p>
                    </div>

                    <div class="grid max-w-xl grid-cols-3 gap-3">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <p class="text-2xl font-extrabold">Blog</p>
                            <p class="mt-1 text-sm text-slate-300">publication</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <p class="text-2xl font-extrabold">Medias</p>
                            <p class="mt-1 text-sm text-slate-300">portfolio</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <p class="text-2xl font-extrabold">Stats</p>
                            <p class="mt-1 text-sm text-slate-300">dashboard</p>
                        </div>
                    </div>
                </section>

                <main class="flex items-center justify-center px-4 py-10 sm:px-6">
                    <div class="w-full max-w-md">
                        <div class="mb-8 text-center lg:hidden">
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-white">
                                <img src="{{ asset('images/logo.PNG') }}" alt="Logo Au-dela des faits" class="h-12 w-12 rounded-2xl object-cover">
                                <span class="text-xl font-extrabold">Au-dela des faits</span>
                            </a>
                        </div>
                        <div class="rounded-[2rem] border border-amber-200/40 bg-white/95 p-7 shadow-2xl shadow-slate-950/40 backdrop-blur sm:p-8">
                            @yield('content')
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
