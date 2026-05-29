@extends('layouts.guest')

@section('content')
<style>
    .login-admin-kicker {
        color: #2563eb;
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: .24em;
        text-transform: uppercase;
    }
    .login-password-field {
        position: relative;
    }
    .login-password-field .form-control {
        padding-right: 3.4rem !important;
    }
    .password-eye-button {
        align-items: center;
        background: #eff6ff;
        border: 1px solid rgba(37, 99, 235, .16);
        border-radius: 999px;
        color: #2563eb;
        display: inline-flex;
        height: 38px;
        justify-content: center;
        position: absolute;
        right: .65rem;
        top: 50%;
        transform: translateY(-50%);
        width: 38px;
    }
    .password-eye-button:hover {
        background: #dbeafe;
        color: #0f172a;
    }
    .admin-login-action {
        display: flex;
        justify-content: center;
        padding-top: .5rem;
    }
    .admin-login-button {
        align-items: center;
        background: linear-gradient(135deg, #020617, #1d4ed8 58%, #0f766e);
        border: 0;
        border-radius: 999px;
        box-shadow: 0 18px 42px rgba(37, 99, 235, .28);
        color: #fff;
        display: inline-flex;
        font-weight: 900;
        gap: .65rem;
        justify-content: center;
        min-height: 54px;
        overflow: hidden;
        padding: .95rem 1.8rem;
        position: relative;
        width: min(100%, 330px);
    }
    .admin-login-button::after {
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.32), transparent);
        content: "";
        inset: 0;
        opacity: 0;
        position: absolute;
        transform: translateX(-70%) skewX(-18deg);
        transition: opacity .2s ease, transform .55s ease;
    }
    .admin-login-button:hover::after {
        opacity: 1;
        transform: translateX(70%) skewX(-18deg);
    }
    .admin-login-button span,
    .admin-login-button svg {
        position: relative;
        z-index: 1;
    }
</style>

<div class="mb-8">
    <p class="login-admin-kicker">Connexion securisee</p>
    <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">Administration</h1>
    <p class="mt-2 text-sm leading-6 text-slate-500">Connectez-vous pour gerer les creneaux, les rendez-vous et le contenu du site.</p>
</div>

@if (session('status'))
    <div class="alert alert-success mb-4">{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ showPassword: false }">
    @csrf

    <div>
        <label for="email" class="form-label fw-bold">Adresse email</label>
        <input id="email" type="email" name="email" value="{{ old('email', 'halimatouk484@gmail.com') }}" required autofocus autocomplete="username" placeholder="halimatouk484@gmail.com" class="form-control rounded-2xl border-slate-300 px-4 py-3 shadow-sm">
    </div>

    <div>
        <label for="password" class="form-label fw-bold">Mot de passe</label>
        <div class="login-password-field">
            <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Votre mot de passe" class="form-control rounded-2xl border-slate-300 px-4 py-3 shadow-sm">
            <button type="button" class="password-eye-button" @click="showPassword = ! showPassword" :aria-label="showPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe'">
                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                    <path d="M3 3l18 18"></path>
                    <path d="M10.6 10.6A3 3 0 0012 15a3 3 0 002.4-4.8"></path>
                    <path d="M9.9 4.2A10.9 10.9 0 0112 4c6.5 0 10 8 10 8a17.8 17.8 0 01-3.2 4.5"></path>
                    <path d="M6.6 6.6C3.7 8.6 2 12 2 12s3.5 8 10 8a10.9 10.9 0 004.7-1"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <label class="form-check-label d-flex align-items-center">
            <input id="remember_me" type="checkbox" name="remember" class="form-check-input me-2"> Se souvenir de moi
        </label>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm text-blue-700 hover:text-blue-900">Mot de passe oublie ?</a>
        @endif
    </div>

    <div class="admin-login-action">
        <button type="submit" class="admin-login-button">
            <span>Acceder au tableau de bord</span>
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        </button>
    </div>
</form>
@endsection
