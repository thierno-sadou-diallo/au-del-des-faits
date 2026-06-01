@extends('layouts.guest')

@section('content')
<div class="space-y-8">
    <div class="space-y-4">
        <div class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-extrabold uppercase tracking-[0.2em] text-blue-700">
            <span class="h-2 w-2 rounded-full bg-emerald-500 shadow-[0_0_0_4px_rgba(16,185,129,.12)]"></span>
            Connexion sécurisée
        </div>

        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-950 sm:text-4xl">Espace administration</h1>
            <p class="mt-3 text-sm leading-6 text-slate-500">
                Accédez au tableau de bord pour gérer les articles, les médias, les rendez-vous et les avis du site.
            </p>
        </div>
    </div>

    @if (session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
            <p class="font-extrabold">Connexion impossible</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ showPassword: false }">
        @csrf

        <div class="space-y-2">
            <label for="email" class="text-sm font-extrabold text-slate-800">Adresse email</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex w-12 items-center justify-center text-slate-400">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6.75A2.75 2.75 0 0 1 6.75 4h10.5A2.75 2.75 0 0 1 20 6.75v10.5A2.75 2.75 0 0 1 17.25 20H6.75A2.75 2.75 0 0 1 4 17.25V6.75Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m5 7 7 6 7-6" />
                    </svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@audeladesfaits.com" class="w-full rounded-2xl border border-slate-200 bg-white py-3.5 pl-12 pr-4 text-sm font-semibold text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
            </div>
        </div>

        <div class="space-y-2">
            <div class="flex items-center justify-between gap-3">
                <label for="password" class="text-sm font-extrabold text-slate-800">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-extrabold text-blue-700 transition hover:text-slate-950">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex w-12 items-center justify-center text-slate-400">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.75 10V7.75a4.25 4.25 0 0 1 8.5 0V10" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 10h10.5A2.75 2.75 0 0 1 20 12.75v4.5A2.75 2.75 0 0 1 17.25 20H6.75A2.75 2.75 0 0 1 4 17.25v-4.5A2.75 2.75 0 0 1 6.75 10Z" />
                    </svg>
                </span>
                <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Votre mot de passe" class="w-full rounded-2xl border border-slate-200 bg-white py-3.5 pl-12 pr-14 text-sm font-semibold text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                <button type="button" class="absolute inset-y-0 right-2 my-auto inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-4 focus:ring-blue-100" @click="showPassword = ! showPassword" :aria-label="showPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe'">
                    <svg x-show="!showPassword" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg>
                    <svg x-show="showPassword" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m3 3 18 18" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.6 10.6A3 3 0 0 0 12 15a3 3 0 0 0 2.4-4.8" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.9 5.8A9 9 0 0 1 12 5.5C18 5.5 21.5 12 21.5 12a14.3 14.3 0 0 1-3 3.7" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.4 6.8A15.2 15.2 0 0 0 2.5 12S6 18.5 12 18.5a8.7 8.7 0 0 0 4-.9" />
                    </svg>
                </button>
            </div>
        </div>

        <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50/60">
            <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
            Garder ma session ouverte
        </label>

        <button type="submit" class="group relative flex w-full items-center justify-center gap-3 overflow-hidden rounded-2xl bg-slate-950 px-5 py-4 text-sm font-extrabold text-white shadow-xl shadow-slate-950/20 transition hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-blue-700/25 focus:outline-none focus:ring-4 focus:ring-blue-200">
            <span class="absolute inset-y-0 left-0 w-24 bg-white/10 opacity-0 transition group-hover:translate-x-[22rem] group-hover:opacity-100"></span>
            <span class="relative">Accéder au tableau de bord</span>
            <svg class="relative h-5 w-5 transition group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </button>

        <p class="text-center text-xs font-semibold leading-5 text-slate-400">
            Accès réservé aux administrateurs autorisés.
        </p>
    </form>
</div>
@endsection
