<x-guest-layout>
    <div class="mb-8">
        <p class="text-sm font-bold uppercase tracking-[0.24em] text-blue-600">Connexion securisee</p>
        <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">Bienvenue dans l'administration</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500">Connectez-vous pour publier, gerer les medias et suivre les statistiques du site.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Adresse email" class="text-slate-700" />
            <x-text-input id="email" class="mt-2 block w-full rounded-2xl border-slate-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@exemple.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Mot de passe" class="text-slate-700" />
            <x-text-input id="password" class="mt-2 block w-full rounded-2xl border-slate-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="Votre mot de passe" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm font-medium text-slate-600">Se souvenir de moi</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-blue-700 hover:text-slate-950" href="{{ route('password.request') }}">
                    Mot de passe oublie ?
                </a>
            @endif
        </div>

        <button class="w-full rounded-2xl bg-gradient-to-r from-slate-950 via-blue-800 to-sky-500 px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-blue-900/20 transition hover:-translate-y-0.5 hover:shadow-xl" type="submit">
            Acceder au tableau de bord
        </button>
    </form>
</x-guest-layout>
