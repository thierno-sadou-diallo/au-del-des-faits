<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            :root {
                --admin-ink: #020617;
                --admin-blue: #2563eb;
                --admin-gold: #f59e0b;
                --admin-earth: #7c2d12;
                --admin-leaf: #15803d;
            }
            body {
                background:
                    linear-gradient(115deg, rgba(180,83,9,.08), transparent 22rem),
                    radial-gradient(circle at 8% 4%, rgba(37,99,235,.14), transparent 28rem),
                    radial-gradient(circle at 92% 18%, rgba(21,128,61,.1), transparent 24rem),
                    linear-gradient(180deg, #f8fafc 0%, #eef4fb 64%, #fff7ed 100%);
            }
            .admin-shell {
                min-height: 100vh;
                overflow-x: hidden;
                position: relative;
            }
            .admin-shell::before {
                background:
                    repeating-linear-gradient(45deg, rgba(245,158,11,.08) 0 2px, transparent 2px 16px),
                    repeating-linear-gradient(-45deg, rgba(21,128,61,.045) 0 2px, transparent 2px 18px);
                content: "";
                inset: 0;
                opacity: .58;
                pointer-events: none;
                position: fixed;
                z-index: 0;
            }
            .admin-shell > * {
                position: relative;
                z-index: 1;
            }
            .admin-topbar {
                background: rgba(248,250,252,.86) !important;
                border-bottom: 1px solid rgba(245,158,11,.28) !important;
                box-shadow: 0 18px 44px rgba(15,23,42,.08);
            }
            .admin-header {
                background:
                    linear-gradient(135deg, rgba(2,6,23,.96), rgba(15,23,42,.92) 48%, rgba(37,99,235,.82)),
                    radial-gradient(circle at 12% 100%, rgba(245,158,11,.22), transparent 16rem) !important;
                border: 1px solid rgba(255,255,255,.14);
                border-radius: 0 0 28px 28px;
                color: #fff;
                overflow: hidden;
                position: relative;
            }
            .admin-header::before {
                background-image:
                    linear-gradient(rgba(255,255,255,.08) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px);
                background-size: 42px 42px;
                content: "";
                inset: 0;
                opacity: .38;
                position: absolute;
            }
            .admin-header > div {
                position: relative;
                z-index: 1;
            }
            .admin-header h1,
            .admin-header p {
                color: inherit !important;
            }
            .admin-header p:first-child,
            .admin-kicker {
                color: #fbbf24 !important;
                font-weight: 900 !important;
                letter-spacing: .24em !important;
                text-transform: uppercase;
            }
            .admin-card,
            main .bg-white {
                background:
                    linear-gradient(180deg, rgba(255,255,255,.98), rgba(255,255,255,.9)),
                    radial-gradient(circle at 92% 8%, rgba(245,158,11,.1), transparent 12rem) !important;
                border-color: rgba(148,163,184,.22) !important;
                box-shadow: 0 18px 50px rgba(15,23,42,.08) !important;
            }
            main input,
            main textarea,
            main select {
                border-radius: 14px !important;
            }
            main input:focus,
            main textarea:focus,
            main select:focus {
                border-color: var(--admin-gold) !important;
                box-shadow: 0 0 0 3px rgba(245,158,11,.14) !important;
            }
            main button,
            main a {
                transition: transform .2s ease, box-shadow .2s ease, background .2s ease, border-color .2s ease, color .2s ease;
            }
            main button:hover,
            main a:hover {
                transform: translateY(-1px);
            }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-900">
        <div class="admin-shell min-h-screen bg-slate-100">
            @include('layouts.navigation')

            @isset($header)
                <header class="admin-header mx-auto max-w-7xl border-b border-amber-200/50 bg-white/90 shadow-sm shadow-slate-900/5 backdrop-blur">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
