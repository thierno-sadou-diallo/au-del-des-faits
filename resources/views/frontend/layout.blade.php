<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $siteName = 'Au-delà des faits';
        $defaultDescription = 'Blog sociologique de Halimatou Keita consacré à la justice sociale, aux droits humains, au Sénégal, à l’Afrique et aux médias.';
        $seoImage = $seoImage ?? asset('images/logo.PNG');
        $youtubeUrl = 'https://youtube.com/@audeladesfaits-s5z?si=9UwlMfEIMBwJHVX_';
    @endphp
    <title>{{ $seoTitle ?? $siteName.' - Blog sociologique' }}</title>
    <meta name="description" content="{{ $seoDescription ?? $defaultDescription }}">
    <meta name="keywords" content="Au-delà des faits, Halimatou Keita, sociologie, justice sociale, Afrique, Sénégal, analyse sociale, droits humains, médias">
    <meta name="author" content="Halimatou Keita">
    <meta name="robots" content="index, follow">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:title" content="{{ $seoTitle ?? $siteName }}">
    <meta property="og:description" content="{{ $seoDescription ?? $defaultDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="{{ $seoTitle ?? $siteName }}">
    <meta property="twitter:description" content="{{ $seoDescription ?? $defaultDescription }}">
    <meta property="twitter:image" content="{{ $seoImage }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Blog',
        'name' => $siteName,
        'url' => url('/'),
        'description' => $seoDescription ?? $defaultDescription,
        'inLanguage' => 'fr',
        'author' => [
            '@type' => 'Person',
            'name' => 'Halimatou Keita',
        ],
        'sameAs' => [
            'https://www.facebook.com/share/r/18SYrbWQMw/',
            'https://www.instagram.com/au_dela_desfaits?igsh=MXB4YmZyYmFndmplMw==',
            'https://www.linkedin.com/company/au-del%C3%A0-des-faits/',
            $youtubeUrl,
            $tiktokUrl,
        ],
    ]) !!}
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --ink: #020617;
            --navy: #0f172a;
            --steel: #334155;
            --muted: #64748b;
            --line: #dbe4ef;
            --paper: #f8fafc;
            --blue: #2563eb;
            --sky: #38bdf8;
            --gold: #f59e0b;
            --coral: #fb7185;
            --terracotta: #b45309;
            --earth: #7c2d12;
            --leaf: #15803d;
            --sand: #fff7ed;
            --soft-blue: #eff6ff;
        }

        html { scroll-behavior: smooth; }
        body {
            min-height: 100vh;
            color: var(--navy);
            font-family: 'Inter', sans-serif;
            background:
                linear-gradient(115deg, rgba(180, 83, 9, .09), transparent 18rem),
                radial-gradient(circle at 12% 8%, rgba(56, 189, 248, .18), transparent 28rem),
                radial-gradient(circle at 88% 16%, rgba(21, 128, 61, .1), transparent 30rem),
                linear-gradient(180deg, #f8fafc 0%, #eef4fb 42%, #fff7ed 100%);
        }
        h1, h2, h3, h4, h5, h6 {
            color: var(--ink);
            font-family: 'Playfair Display', serif;
            letter-spacing: 0;
        }
        a { color: var(--blue); }
        p, li, .text-muted, .card-text {
            color: #475569 !important;
            line-height: 1.75;
        }
        .gradient-text {
            background: linear-gradient(92deg, #020617 0%, #2563eb 52%, #38bdf8 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent !important;
            display: inline-block;
        }
        .hero-bg .gradient-text,
        .page-hero .gradient-text {
            background: linear-gradient(92deg, #fff 0%, #93c5fd 52%, #38bdf8 100%);
            -webkit-background-clip: text;
            background-clip: text;
        }
        .section-kicker {
            color: #2563eb;
            font-size: .78rem;
            font-weight: 900;
            letter-spacing: .18em;
            text-transform: uppercase;
        }
        .site-shell { overflow-x: hidden; }
        .site-shell::before {
            background:
                linear-gradient(115deg, transparent 0 32%, rgba(255,255,255,.34) 32% 32.6%, transparent 32.6%),
                linear-gradient(65deg, transparent 0 58%, rgba(180,83,9,.12) 58% 58.5%, transparent 58.5%),
                repeating-linear-gradient(90deg, transparent 0 72px, rgba(21,128,61,.035) 72px 73px, transparent 73px 144px);
            content: "";
            inset: 0;
            pointer-events: none;
            position: fixed;
            z-index: -2;
        }
        .reading-progress {
            background: linear-gradient(90deg, var(--earth), var(--gold), var(--leaf), var(--blue));
            height: 3px;
            left: 0;
            position: fixed;
            top: 0;
            transform: scaleX(var(--scroll-progress, 0));
            transform-origin: left;
            width: 100%;
            z-index: 1080;
        }
        body.reader-focus .ticker,
        body.reader-focus .heritage-ribbon,
        body.reader-focus .decor-field,
        body.reader-focus .ambient-art,
        body.reader-focus .cursor-glow {
            opacity: 0;
            pointer-events: none;
        }
        body.reader-focus main.site-main {
            max-width: 980px;
        }
        body.reader-focus .card,
        body.reader-focus .art-card,
        body.reader-focus .page-hero {
            box-shadow: 0 18px 54px rgba(15, 23, 42, .1) !important;
        }
        .cursor-glow {
            background: radial-gradient(circle, rgba(245,158,11,.18), rgba(56,189,248,.12) 38%, transparent 68%);
            border-radius: 999px;
            height: 320px;
            left: var(--cursor-x, 50%);
            opacity: .75;
            pointer-events: none;
            position: fixed;
            top: var(--cursor-y, 20%);
            transform: translate(-50%, -50%);
            transition: left .18s ease, top .18s ease;
            width: 320px;
            z-index: -1;
        }
        .decor-field {
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            position: fixed;
            z-index: -1;
        }
        .decor-field span {
            position: absolute;
        }
        .decor-line {
            animation: decor-slide 18s ease-in-out infinite alternate;
            background: linear-gradient(180deg, transparent, rgba(245,158,11,.34), rgba(37,99,235,.22), transparent);
            height: 46vh;
            width: 1px;
        }
        .decor-line.one { left: 5vw; top: 20vh; }
        .decor-line.two { animation-delay: -6s; right: 7vw; top: 8vh; }
        .decor-ring {
            animation: decor-spin 30s linear infinite;
            border: 1px solid rgba(245,158,11,.2);
            border-radius: 45% 55% 38% 62%;
            height: 190px;
            width: 190px;
        }
        .decor-ring.one { left: 74vw; top: 62vh; }
        .decor-ring.two { animation-direction: reverse; bottom: 9vh; height: 130px; left: 7vw; width: 130px; }
        .decor-word {
            animation: word-float 9s ease-in-out infinite alternate;
            color: rgba(15,23,42,.06);
            font-family: 'Playfair Display', serif;
            font-size: clamp(3rem, 8vw, 7rem);
            font-weight: 800;
            line-height: 1;
            white-space: nowrap;
        }
        .decor-word.one { left: -2vw; top: 34vh; transform: rotate(-8deg); }
        .decor-word.two { animation-delay: -4s; right: -7vw; top: 74vh; transform: rotate(8deg); }
        .ambient-art {
            inset: 0;
            pointer-events: none;
            position: fixed;
            z-index: -1;
        }
        .ambient-art span {
            animation: drift 16s ease-in-out infinite alternate;
            background: linear-gradient(135deg, rgba(37,99,235,.12), rgba(245,158,11,.08));
            border: 1px solid rgba(245,158,11,.14);
            border-radius: 34% 66% 62% 38%;
            filter: blur(.2px);
            position: absolute;
        }
        .ambient-art span:nth-child(1) { height: 180px; left: -40px; top: 18%; width: 180px; }
        .ambient-art span:nth-child(2) { animation-delay: -5s; height: 260px; right: -90px; top: 38%; width: 260px; }
        .ambient-art span:nth-child(3) { animation-delay: -9s; bottom: 10%; height: 150px; left: 12%; width: 150px; }
        .african-decor {
            background:
                repeating-linear-gradient(45deg, rgba(245, 158, 11, .09) 0, rgba(245, 158, 11, .09) 2px, transparent 2px, transparent 14px),
                repeating-linear-gradient(-45deg, rgba(21, 128, 61, .06) 0, rgba(21, 128, 61, .06) 2px, transparent 2px, transparent 14px),
                linear-gradient(135deg, rgba(2,6,23,.03), transparent);
            position: relative;
            overflow: hidden;
        }
        .african-decor::before {
            content: "";
            inset: 0;
            position: absolute;
            background: radial-gradient(circle at 18% 22%, rgba(56,189,248,.12), transparent 24%),
                        radial-gradient(circle at 82% 20%, rgba(245,158,11,.12), transparent 28%),
                        radial-gradient(circle at 40% 100%, rgba(21,128,61,.1), transparent 24%);
            pointer-events: none;
            z-index: 0;
        }
        .african-decor::after {
            background:
                linear-gradient(90deg, rgba(255,255,255,.1), transparent 18%, rgba(255,255,255,.08) 42%, transparent 64%),
                repeating-linear-gradient(90deg, transparent 0 18px, rgba(255,255,255,.09) 18px 19px, transparent 19px 38px);
            bottom: 0;
            content: "";
            height: 10px;
            left: 0;
            position: absolute;
            right: 0;
            z-index: 1;
        }
        .african-decor > * {
            position: relative;
            z-index: 1;
        }
        section {
            background:
                radial-gradient(circle at 5% 15%, rgba(37, 99, 235, .04) 0%, transparent 25%),
                radial-gradient(circle at 95% 85%, rgba(56, 189, 248, .03) 0%, transparent 25%),
                radial-gradient(ellipse 800px 400px at 50% 50%, rgba(37, 99, 235, .02) 0%, transparent 70%);
            position: relative;
        }
        .navbar {
            border-bottom: 1px solid rgba(148, 163, 184, .24);
            background: rgba(248, 250, 252, .82) !important;
            backdrop-filter: blur(18px);
            box-shadow: 0 18px 40px rgba(15, 23, 42, .06) !important;
        }
        .brand-mark {
            align-items: center;
            color: var(--ink) !important;
            display: inline-flex;
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 800;
            gap: .75rem;
            text-decoration: none;
        }
        .brand-mark img {
            border-radius: 12px;
            box-shadow: 0 14px 30px rgba(15, 23, 42, .2);
            height: 56px;
            object-fit: cover;
            transition: transform .24s ease, box-shadow .24s ease;
            width: 56px;
        }
        .brand-mark:hover img {
            box-shadow: 0 18px 36px rgba(37, 99, 235, .22);
            transform: rotate(-3deg) scale(1.04);
        }
        .nav-link {
            color: var(--steel) !important;
            font-size: .92rem;
            font-weight: 700;
            position: relative;
        }
        .nav-link:hover,
        .nav-link.active { color: var(--ink) !important; }
        .nav-link::after {
            background: linear-gradient(90deg, var(--gold), var(--blue), var(--sky));
            border-radius: 999px;
            bottom: .25rem;
            content: "";
            height: 2px;
            left: .5rem;
            position: absolute;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .22s ease;
            width: calc(100% - 1rem);
        }
        .nav-link:hover::after,
        .nav-link.active::after { transform: scaleX(1); }
        main.site-main { padding-top: 2.5rem; }
        .experience-dock {
            bottom: 1.25rem;
            display: grid;
            gap: .55rem;
            position: fixed;
            right: 1.25rem;
            z-index: 1040;
        }
        .dock-button {
            align-items: center;
            background: rgba(2, 6, 23, .88);
            border: 1px solid rgba(245, 158, 11, .24);
            border-radius: 999px;
            box-shadow: 0 18px 44px rgba(2, 6, 23, .2);
            color: #fff;
            display: inline-flex;
            height: 48px;
            justify-content: center;
            position: relative;
            text-decoration: none;
            transition: transform .2s ease, background .2s ease, border-color .2s ease;
            width: 48px;
        }
        .dock-button:hover,
        .dock-button:focus-visible {
            background: linear-gradient(135deg, var(--earth), var(--blue));
            border-color: rgba(251, 191, 36, .52);
            color: #fff;
            transform: translateY(-3px) scale(1.04);
        }
        .dock-button span {
            background: #020617;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 999px;
            box-shadow: 0 12px 26px rgba(2, 6, 23, .2);
            color: #fff;
            font-size: .78rem;
            font-weight: 800;
            opacity: 0;
            padding: .45rem .7rem;
            pointer-events: none;
            position: absolute;
            right: calc(100% + .65rem);
            transform: translateX(8px);
            transition: opacity .2s ease, transform .2s ease;
            white-space: nowrap;
        }
        .dock-button:hover span,
        .dock-button:focus-visible span {
            opacity: 1;
            transform: translateX(0);
        }
        .spotlight-backdrop {
            align-items: flex-start;
            background: rgba(2, 6, 23, .56);
            display: none;
            inset: 0;
            justify-content: center;
            padding: min(10vh, 5rem) 1rem 1rem;
            position: fixed;
            z-index: 1090;
        }
        .spotlight-backdrop.is-open {
            display: flex;
        }
        .spotlight-panel {
            background:
                linear-gradient(180deg, rgba(255,255,255,.98), rgba(255,247,237,.94)),
                radial-gradient(circle at 85% 8%, rgba(245,158,11,.18), transparent 12rem);
            border: 1px solid rgba(255,255,255,.5);
            border-radius: 26px;
            box-shadow: 0 34px 110px rgba(2, 6, 23, .34);
            max-width: 680px;
            overflow: hidden;
            width: 100%;
        }
        .spotlight-head {
            align-items: center;
            border-bottom: 1px solid rgba(148, 163, 184, .22);
            display: flex;
            gap: .85rem;
            padding: 1rem 1.15rem;
        }
        .spotlight-head i {
            color: var(--terracotta);
        }
        .spotlight-input {
            background: transparent;
            border: 0;
            color: var(--ink);
            flex: 1;
            font-size: 1rem;
            font-weight: 700;
            outline: 0;
        }
        .spotlight-close {
            background: rgba(15,23,42,.08);
            border: 0;
            border-radius: 999px;
            color: var(--ink);
            height: 34px;
            width: 34px;
        }
        .spotlight-list {
            display: grid;
            gap: .55rem;
            max-height: 60vh;
            overflow: auto;
            padding: .85rem;
        }
        .spotlight-item {
            align-items: center;
            background: rgba(255,255,255,.72);
            border: 1px solid rgba(148, 163, 184, .2);
            border-radius: 18px;
            color: var(--ink);
            display: flex;
            gap: .85rem;
            padding: .85rem;
            text-decoration: none;
            transition: transform .18s ease, border-color .18s ease, background .18s ease;
        }
        .spotlight-item:hover,
        .spotlight-item.is-active {
            background: #fff;
            border-color: rgba(245, 158, 11, .4);
            color: var(--ink);
            transform: translateX(5px);
        }
        .spotlight-item i {
            align-items: center;
            background: linear-gradient(135deg, var(--ink), var(--blue));
            border-radius: 14px;
            color: #fff;
            display: inline-flex;
            flex: 0 0 auto;
            height: 42px;
            justify-content: center;
            width: 42px;
        }
        .spotlight-item strong {
            display: block;
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            line-height: 1.1;
        }
        .spotlight-item small {
            color: #64748b;
            display: block;
            font-weight: 700;
            margin-top: .15rem;
        }
        .spotlight-empty {
            color: #64748b;
            display: none;
            font-weight: 800;
            padding: 1rem;
            text-align: center;
        }
        .site-pagination {
            align-items: center;
            display: flex;
            flex-direction: column;
            gap: .75rem;
            margin-top: 2rem;
        }
        .pagination-shell {
            align-items: center;
            background: rgba(255, 255, 255, .84);
            border: 1px solid rgba(148, 163, 184, .24);
            border-radius: 999px;
            box-shadow: 0 18px 48px rgba(15, 23, 42, .08);
            display: flex;
            flex-wrap: wrap;
            gap: .45rem;
            justify-content: center;
            padding: .45rem;
        }
        .pagination-pages {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: .35rem;
            justify-content: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .page-number,
        .page-step,
        .page-dot {
            align-items: center;
            border-radius: 999px !important;
            color: var(--ink);
            display: inline-flex;
            font-weight: 800;
            height: 42px;
            justify-content: center;
            min-width: 42px;
            padding: .45rem .85rem;
            text-decoration: none;
            transition: transform .18s ease, background .18s ease, border-color .18s ease;
        }
        .page-number {
            background: rgba(248, 250, 252, .94);
            border: 1px solid rgba(148, 163, 184, .22);
        }
        .page-step {
            background: #0f172a;
            color: #fff;
            min-width: 104px;
        }
        .page-number:hover,
        .page-step:hover {
            background: #eff6ff;
            border-color: rgba(37, 99, 235, .42);
            color: var(--blue);
            transform: translateY(-2px);
        }
        .page-number.is-active {
            background: linear-gradient(135deg, var(--ink), var(--blue));
            border-color: transparent;
            color: #fff;
        }
        .page-step.is-disabled,
        .page-dot {
            background: rgba(226, 232, 240, .72);
            color: #94a3b8;
            transform: none;
            pointer-events: none;
        }
        .pagination-summary {
            color: #64748b !important;
            font-size: .85rem;
            font-weight: 800;
            margin: 0;
        }
        .ticker {
            background: var(--ink);
            border-bottom: 1px solid rgba(56, 189, 248, .24);
            color: #fff;
            overflow: hidden;
            white-space: nowrap;
        }
        .ticker-track {
            animation: ticker-scroll 28s linear infinite;
            display: inline-flex;
            gap: 2rem;
            min-width: max-content;
            padding: .65rem 0;
        }
        .ticker span {
            align-items: center;
            color: rgba(226,232,240,.88);
            display: inline-flex;
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        .ticker span::before {
            background: var(--gold);
            border-radius: 999px;
            content: "";
            height: 7px;
            margin-right: .85rem;
            width: 7px;
        }
        .heritage-ribbon {
            background:
                linear-gradient(90deg, #7c2d12, #0f172a 24%, #15803d 50%, #0f172a 74%, #b45309),
                repeating-linear-gradient(45deg, rgba(255,255,255,.12) 0 2px, transparent 2px 10px);
            border-bottom: 1px solid rgba(245, 158, 11, .24);
            color: #fff;
            overflow: hidden;
            position: relative;
        }
        .heritage-ribbon::before,
        .heritage-ribbon::after {
            background: repeating-linear-gradient(90deg, rgba(255,255,255,.24) 0 8px, transparent 8px 16px);
            content: "";
            height: 2px;
            left: 0;
            position: absolute;
            right: 0;
        }
        .heritage-ribbon::before { top: 0; }
        .heritage-ribbon::after { bottom: 0; }
        .heritage-track {
            animation: heritage-scroll 34s linear infinite;
            display: inline-flex;
            gap: 1.6rem;
            min-width: max-content;
            padding: .55rem 0;
            white-space: nowrap;
        }
        .heritage-track span {
            color: rgba(255,255,255,.9);
            font-family: 'Playfair Display', serif;
            font-size: .95rem;
            font-weight: 800;
        }
        .heritage-track span::after {
            color: #fbbf24;
            content: " /";
            margin-left: 1.6rem;
        }
        .hero-bg,
        .page-hero,
        .rounded-4.bg-white.shadow-sm.p-5 {
            background:
                linear-gradient(135deg, rgba(2, 6, 23, .97), rgba(15, 23, 42, .93) 42%, rgba(30, 64, 175, .82)),
                radial-gradient(circle at 82% 20%, rgba(56, 189, 248, .34), transparent 18rem),
                radial-gradient(circle at 12% 88%, rgba(245, 158, 11, .26), transparent 17rem),
                radial-gradient(circle at 92% 92%, rgba(21, 128, 61, .18), transparent 16rem) !important;
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: 24px !important;
            box-shadow: 0 28px 80px rgba(15, 23, 42, .22) !important;
            color: #fff;
            overflow: hidden;
            position: relative;
        }
        .hero-bg::after,
        .page-hero::after,
        .rounded-4.bg-white.shadow-sm.p-5::after {
            animation: shine-sweep 8s ease-in-out infinite;
            background: linear-gradient(110deg, transparent 0%, rgba(255,255,255,.14) 48%, transparent 62%);
            content: "";
            height: 140%;
            left: -70%;
            position: absolute;
            top: -20%;
            transform: rotate(8deg);
            width: 45%;
            z-index: 1;
        }
        .hero-bg::before,
        .page-hero::before,
        .rounded-4.bg-white.shadow-sm.p-5::before {
            background-image:
                linear-gradient(rgba(255,255,255,.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px);
            background-size: 44px 44px;
            content: "";
            inset: 0;
            opacity: .34;
            position: absolute;
        }
        .hero-bg::selection,
        .page-hero::selection {
            background: var(--gold);
            color: var(--ink);
        }
        .hero-bg > *,
        .page-hero > *,
        .rounded-4.bg-white.shadow-sm.p-5 > * {
            position: relative;
            z-index: 1;
        }
        .hero-bg h1,
        .hero-bg h2,
        .page-hero h1,
        .rounded-4.bg-white.shadow-sm.p-5 h1,
        .rounded-4.bg-white.shadow-sm.p-5 h2 { color: #fff; }
        .hero-bg .lead,
        .page-hero .lead,
        .rounded-4.bg-white.shadow-sm.p-5 .lead { color: rgba(226, 232, 240, .92) !important; }
        .hero-bg p,
        .page-hero p,
        .hero-bg li,
        .page-hero li { color: rgba(226, 232, 240, .9) !important; }
        .badge,
        .bg-primary,
        .bg-success,
        .bg-info,
        .bg-warning {
            background: linear-gradient(135deg, var(--ink), var(--blue) 56%, var(--gold)) !important;
            color: #fff !important;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        .text-primary,
        .text-success,
        .text-info,
        .text-warning { color: var(--blue) !important; }
        .btn {
            border-radius: 999px;
            font-weight: 800;
            letter-spacing: 0;
            padding-inline: 1.2rem;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease, border-color .2s ease;
        }
        .btn:hover {
            box-shadow: 0 16px 34px rgba(15, 23, 42, .18);
            transform: translateY(-2px);
        }
        .btn-primary,
        .btn-success,
        .btn-info,
        .btn-warning {
            background: linear-gradient(135deg, var(--ink), var(--blue) 56%, var(--terracotta)) !important;
            border-color: transparent !important;
            color: #fff !important;
        }
        .btn-outline-primary,
        .btn-outline-secondary {
            background: rgba(255,255,255,.68);
            border-color: rgba(37, 99, 235, .28) !important;
            color: var(--ink) !important;
        }
        .btn-outline-primary:hover,
        .btn-outline-secondary:hover {
            background: linear-gradient(135deg, var(--ink), var(--earth)) !important;
            border-color: var(--ink) !important;
            color: #fff !important;
        }
        .card {
            background:
                linear-gradient(180deg, rgba(255,255,255,.98), rgba(255,255,255,.86)),
                radial-gradient(circle at 88% 8%, rgba(245,158,11,.1), transparent 11rem);
            border: 1px solid rgba(148, 163, 184, .24) !important;
            border-radius: 18px;
            box-shadow: 0 18px 50px rgba(15, 23, 42, .08) !important;
            overflow: hidden;
            transition: transform .26s ease, box-shadow .26s ease, border-color .26s ease;
        }
        .card::before {
            background: linear-gradient(90deg, #7c2d12, #f59e0b, #15803d, #2563eb);
            content: "";
            height: 3px;
            left: 0;
            opacity: 0;
            position: absolute;
            top: 0;
            transition: opacity .24s ease;
            width: 100%;
            z-index: 2;
        }
        .card:hover {
            border-color: rgba(245, 158, 11, .34) !important;
            box-shadow: 0 26px 70px rgba(15, 23, 42, .14) !important;
            transform: translateY(-6px);
        }
        .card:hover::before {
            opacity: 1;
        }
        .decor-band {
            background:
                linear-gradient(90deg, transparent, rgba(124,45,18,.18), rgba(245,158,11,.28), rgba(21,128,61,.18), rgba(56,189,248,.2), transparent);
            height: 1px;
            margin: 3rem 0;
            position: relative;
        }
        .decor-band::after {
            animation: band-dot 4s ease-in-out infinite alternate;
            background: #f59e0b;
            border-radius: 999px;
            box-shadow: 0 0 24px rgba(245,158,11,.75);
            content: "";
            height: 10px;
            left: 14%;
            position: absolute;
            top: -4px;
            width: 10px;
        }
        .art-card {
            background:
                linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,255,255,.72)),
                radial-gradient(circle at 80% 20%, rgba(56,189,248,.18), transparent 12rem),
                radial-gradient(circle at 8% 90%, rgba(245,158,11,.16), transparent 10rem),
                repeating-linear-gradient(135deg, rgba(124,45,18,.035) 0 2px, transparent 2px 18px);
            border: 1px solid rgba(148, 163, 184, .24);
            border-radius: 22px;
            box-shadow: 0 20px 60px rgba(15, 23, 42, .1);
            overflow: hidden;
            position: relative;
        }
        .art-card::after {
            background: linear-gradient(90deg, #7c2d12, #f59e0b, #15803d, #2563eb);
            bottom: 0;
            content: "";
            height: 4px;
            left: 0;
            position: absolute;
            width: 100%;
        }
        .card-img-top,
        .img-fluid.rounded-4 {
            aspect-ratio: 16 / 10;
            object-fit: cover;
        }
        .card-img-top {
            filter: saturate(1.06) contrast(1.04);
            transition: transform .42s ease, filter .42s ease;
        }
        .card:hover .card-img-top {
            filter: saturate(1.12) contrast(1.06);
            transform: scale(1.045);
        }
        .bg-light,
        .alert-primary,
        .alert-info {
            background: rgba(239, 246, 255, .76) !important;
            border-color: rgba(37, 99, 235, .14) !important;
        }
        .form-control,
        .form-select {
            border-color: rgba(148, 163, 184, .48);
            border-radius: 14px;
            padding: .78rem .95rem;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: var(--terracotta);
            box-shadow: 0 0 0 .22rem rgba(245, 158, 11, .14);
        }
        .content {
            font-size: 1.06rem;
            line-height: 1.9;
        }
        .social-links a {
            align-items: center;
            background: rgba(37, 99, 235, .1);
            border: 1px solid rgba(37, 99, 235, .16);
            border-radius: 999px;
            color: var(--blue);
            display: inline-flex;
            height: 38px;
            justify-content: center;
            margin: 0 6px 8px 0;
            text-decoration: none;
            transition: transform .2s ease, background .2s ease, color .2s ease;
            width: 38px;
        }
        .social-links a:hover {
            background: linear-gradient(135deg, var(--ink), var(--blue));
            color: #fff;
            transform: translateY(-3px);
        }
        .list-group-item {
            background: rgba(255,255,255,.72);
            border-color: rgba(148, 163, 184, .2);
            color: var(--steel);
            font-weight: 700;
            transition: color .2s ease, padding-left .2s ease, background .2s ease;
        }
        .list-group-item:hover {
            background: rgba(239,246,255,.9);
            color: var(--blue);
            padding-left: 1.25rem;
        }
        .pagination {
            gap: .35rem;
        }
        .page-link {
            border: 1px solid rgba(148, 163, 184, .26);
            border-radius: 999px !important;
            color: var(--ink);
            font-weight: 800;
        }
        .active > .page-link,
        .page-link:hover {
            background: linear-gradient(135deg, var(--ink), var(--blue));
            border-color: transparent;
            color: #fff;
        }
        .section-frame {
            border: 1px solid rgba(148, 163, 184, .2);
            border-radius: 24px;
            padding: clamp(1rem, 2vw, 1.5rem);
            position: relative;
        }
        .section-frame::before {
            background:
                linear-gradient(90deg, rgba(245,158,11,.4), transparent),
                linear-gradient(180deg, rgba(37,99,235,.28), transparent);
            border-radius: inherit;
            content: "";
            inset: 0;
            opacity: .5;
            pointer-events: none;
            position: absolute;
        }
        .section-frame > * {
            position: relative;
            z-index: 1;
        }
        .tilt-card {
            transform: perspective(900px) rotateX(var(--tilt-y, 0deg)) rotateY(var(--tilt-x, 0deg));
            transition: transform .16s ease, box-shadow .24s ease;
        }
        @media (max-width: 767.98px) {
            .experience-dock {
                background: rgba(248, 250, 252, .86);
                border: 1px solid rgba(148, 163, 184, .24);
                border-radius: 999px;
                bottom: .75rem;
                box-shadow: 0 18px 44px rgba(15, 23, 42, .12);
                display: flex;
                left: 50%;
                padding: .45rem;
                right: auto;
                transform: translateX(-50%);
            }
            .dock-button {
                height: 42px;
                width: 42px;
            }
            .dock-button span {
                display: none;
            }
            .site-footer {
                padding-bottom: 6rem !important;
            }
            .pagination-shell {
                border-radius: 24px;
                width: 100%;
            }
            .page-step {
                flex: 1 1 120px;
            }
        }
        .mb-6 { margin-bottom: 5rem !important; }
        .mt-6 { margin-top: 5rem !important; }
        .site-footer {
            background:
                repeating-linear-gradient(45deg, rgba(255,255,255,.035) 0 2px, transparent 2px 14px),
                linear-gradient(135deg, #020617, #0f172a 48%, #7c2d12 78%, #1e3a8a) !important;
            margin-top: 5rem !important;
        }
        .site-footer p,
        .site-footer li,
        .site-footer a,
        .site-footer .text-white-50 {
            color: rgba(226, 232, 240, .72) !important;
        }
        .heart-burst {
            animation: heart-float .9s ease-out forwards;
            color: #2563eb;
            font-size: 1.25rem;
            font-weight: 900;
            left: var(--x);
            pointer-events: none;
            position: fixed;
            text-shadow: 0 10px 20px rgba(15,23,42,.18);
            top: var(--y);
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
        .footer-brand {
            align-items: center;
            display: inline-flex;
            gap: .75rem;
        }
        .footer-brand img {
            height: 40px;
            object-fit: cover;
            border-radius: 12px;
            width: 40px;
        }
        [data-reveal] {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .7s ease, transform .7s ease;
        }
        [data-reveal].is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
            [data-reveal] { opacity: 1; transform: none; }
        }
        @keyframes ticker-scroll {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }
        @keyframes heritage-scroll {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }
        @keyframes drift {
            from { transform: translate3d(0, 0, 0) rotate(0deg); }
            to { transform: translate3d(26px, -34px, 0) rotate(18deg); }
        }
        @keyframes heart-float {
            0% { opacity: 0; transform: translate(-50%, -20%) scale(.65) rotate(-8deg); }
            15% { opacity: 1; }
            100% { opacity: 0; transform: translate(calc(-50% + var(--dx)), -150px) scale(1.35) rotate(18deg); }
        }
        @keyframes decor-slide {
            from { transform: translateY(-36px); opacity: .45; }
            to { transform: translateY(52px); opacity: .9; }
        }
        @keyframes decor-spin {
            to { transform: rotate(360deg); }
        }
        @keyframes word-float {
            from { opacity: .04; transform: translateY(0) rotate(var(--word-rotate, -8deg)); }
            to { opacity: .09; transform: translateY(-34px) rotate(var(--word-rotate, -8deg)); }
        }
        @keyframes shine-sweep {
            0%, 48% { left: -70%; opacity: 0; }
            55% { opacity: 1; }
            75%, 100% { left: 120%; opacity: 0; }
        }
        @keyframes band-dot {
            from { left: 14%; }
            to { left: 84%; }
        }
    </style>
    @stack('styles')
</head>
<body class="site-shell">
    <div class="reading-progress" aria-hidden="true"></div>
    <div class="cursor-glow" aria-hidden="true"></div>
    <div class="decor-field" aria-hidden="true">
        <span class="decor-line one"></span>
        <span class="decor-line two"></span>
        <span class="decor-ring one"></span>
        <span class="decor-ring two"></span>
        <span class="decor-word one" style="--word-rotate: -8deg;">Analyse</span>
        <span class="decor-word two" style="--word-rotate: 8deg;">Justice</span>
    </div>
    <div class="ambient-art" aria-hidden="true"><span></span><span></span><span></span></div>
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand brand-mark" href="{{ route('home') }}">
                <picture>
                    <source srcset="{{ asset('images/logo.webp') }}" type="image/webp">
                    <img src="{{ asset('images/logo.PNG') }}" alt="Logo Au-delà des faits" width="56" height="56" decoding="async">
                </picture>
                <span>Au-delà des faits</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">À propos</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}" href="{{ route('blog.index') }}">Articles</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('thematiques') ? 'active' : '' }}" href="{{ route('thematiques') }}">Thématiques</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('medias') ? 'active' : '' }}" href="{{ route('medias') }}">Médias</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('appointment*') ? 'active' : '' }}" href="{{ route('appointment.fr') }}">Rendez-vous</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li>
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>
                    @endguest
                    @auth
                        @if(auth()->user()->is_admin)
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="ticker" aria-hidden="true">
        <div class="ticker-track">
            <span>Analyses sociologiques</span>
            <span>Droits humains</span>
            <span>Médias & interviews</span>
            <span>Afrique contemporaine</span>
            <span>Justice sociale</span>
            <span>Communication responsable</span>
            <span>Analyses sociologiques</span>
            <span>Droits humains</span>
            <span>Médias & interviews</span>
            <span>Afrique contemporaine</span>
            <span>Justice sociale</span>
            <span>Communication responsable</span>
        </div>
    </div>

    <div class="heritage-ribbon" aria-hidden="true">
        <div class="heritage-track">
            <span>Memoire sociale</span>
            <span>Parole publique</span>
            <span>Afrique contemporaine</span>
            <span>Dignite humaine</span>
            <span>Terrain & recits</span>
            <span>Analyse engagee</span>
            <span>Memoire sociale</span>
            <span>Parole publique</span>
            <span>Afrique contemporaine</span>
            <span>Dignite humaine</span>
            <span>Terrain & recits</span>
            <span>Analyse engagee</span>
        </div>
    </div>

    <div class="experience-dock" aria-label="Navigation rapide">
        <button class="dock-button" type="button" id="open-spotlight" aria-label="Recherche rapide">
            <i class="fas fa-magnifying-glass"></i>
            <span>Recherche</span>
        </button>
        <button class="dock-button" type="button" id="toggle-reader-focus" aria-label="Mode lecture">
            <i class="fas fa-book-open-reader"></i>
            <span>Mode lecture</span>
        </button>
        <a class="dock-button" href="{{ route('blog.index') }}" aria-label="Articles">
            <i class="fas fa-newspaper"></i>
            <span>Articles</span>
        </a>
        <a class="dock-button" href="{{ route('contact') }}" aria-label="Contact">
            <i class="fas fa-paper-plane"></i>
            <span>Contact</span>
        </a>
        <button class="dock-button" type="button" id="scroll-top" aria-label="Retour en haut">
            <i class="fas fa-arrow-up"></i>
            <span>Haut</span>
        </button>
    </div>

    <div class="spotlight-backdrop" id="spotlight" role="dialog" aria-modal="true" aria-label="Recherche rapide">
        <div class="spotlight-panel">
            <div class="spotlight-head">
                <i class="fas fa-magnifying-glass"></i>
                <input class="spotlight-input" id="spotlight-input" type="search" placeholder="Rechercher une page, un thème, une action..." autocomplete="off">
                <button class="spotlight-close" type="button" id="close-spotlight" aria-label="Fermer">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
            <div class="spotlight-list" id="spotlight-list">
                <a class="spotlight-item" href="{{ route('home') }}" data-search="accueil au-dela des faits blog sociologie">
                    <i class="fas fa-house"></i>
                    <span><strong>Accueil</strong><small>Revenir à la page principale</small></span>
                </a>
                <a class="spotlight-item" href="{{ route('blog.index') }}" data-search="articles blog publications analyses sociologiques lecture">
                    <i class="fas fa-newspaper"></i>
                    <span><strong>Articles</strong><small>Lire les dernières analyses</small></span>
                </a>
                <a class="spotlight-item" href="{{ route('thematiques') }}" data-search="thematiques justice sociale afrique droits humains methodologie">
                    <i class="fas fa-layer-group"></i>
                    <span><strong>Thématiques</strong><small>Explorer les grands axes sociaux</small></span>
                </a>
                <a class="spotlight-item" href="{{ route('medias') }}" data-search="medias videos photos interviews archives interventions">
                    <i class="fas fa-photo-film"></i>
                    <span><strong>Médias</strong><small>Voir les images, vidéos et interventions</small></span>
                </a>
                <a class="spotlight-item" href="{{ route('services') }}" data-search="services accompagnement conseil formation">
                    <i class="fas fa-compass-drafting"></i>
                    <span><strong>Services</strong><small>Découvrir les accompagnements possibles</small></span>
                </a>
                <a class="spotlight-item" href="{{ route('about') }}" data-search="a propos profil halimatou keita mission expertise">
                    <i class="fas fa-user-pen"></i>
                    <span><strong>À propos</strong><small>Comprendre la voix du site</small></span>
                </a>
                <a class="spotlight-item" href="{{ route('contact') }}" data-search="contact email message collaboration demande">
                    <i class="fas fa-paper-plane"></i>
                    <span><strong>Contact</strong><small>Envoyer une demande</small></span>
                </a>
                <a class="spotlight-item" href="{{ route('appointment.fr') }}" data-search="rendez-vous creneau disponibilite reservation demande suivi">
                    <i class="fas fa-calendar-check"></i>
                    <span><strong>Rendez-vous</strong><small>Demander ou suivre un rendez-vous</small></span>
                </a>
            </div>
            <div class="spotlight-empty" id="spotlight-empty">Aucun résultat. Essayez "articles", "médias", "contact" ou "justice".</div>
        </div>
    </div>

    <main class="container site-main">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="site-footer text-light py-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <div class="footer-brand mb-3">
                        <picture>
                            <source srcset="{{ asset('images/logo.webp') }}" type="image/webp">
                            <img src="{{ asset('images/logo.PNG') }}" alt="Logo Au-delà des faits" width="56" height="56" loading="lazy" decoding="async">
                        </picture>
                        <h5 class="text-uppercase mb-0 text-white">Au-delà des faits</h5>
                    </div>
                    <p class="text-white-50">Mettre la communication et l'analyse sociologique au service de l'intérêt général.</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/share/r/18SYrbWQMw/" class="fab fa-facebook-f" aria-label="Facebook" target="_blank" rel="noopener"></a>
                        <a href="https://www.instagram.com/au_dela_desfaits?igsh=MXB4YmZyYmFndmplMw==" class="fab fa-instagram" aria-label="Instagram" target="_blank" rel="noopener"></a>
                        <a href="https://www.linkedin.com/company/au-del%C3%A0-des-faits/" class="fab fa-linkedin-in" aria-label="LinkedIn" target="_blank" rel="noopener"></a>
                        <a href="{{ $youtubeUrl }}" class="fab fa-youtube" aria-label="YouTube" target="_blank" rel="noopener"></a>
                        <a href="{{ $tiktokUrl }}" class="fab fa-tiktok" aria-label="TikTok" target="_blank" rel="noopener"></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3 text-white">Liens utiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('blog.index') }}" class="text-white-50">Articles</a></li>
                        <li><a href="{{ route('thematiques') }}" class="text-white-50">Thématiques</a></li>
                        <li><a href="{{ route('medias') }}" class="text-white-50">Médias</a></li>
                        <li><a href="{{ url('/sitemap.xml') }}" class="text-white-50">Sitemap</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3 text-white">Newsletter</h5>
                    <form method="POST" action="{{ route('newsletter.subscribe') }}" class="d-flex gap-2">
                        @csrf
                        <input type="email" name="email" class="form-control" placeholder="Votre email" required>
                        <button class="btn btn-primary" type="submit">S'inscrire</button>
                    </form>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <p class="text-center text-white-50 mb-0">&copy; {{ date('Y') }} Au-delà des faits. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('main > .row, main > section, .card').forEach((element) => {
            element.setAttribute('data-reveal', '');
        });

        document.querySelectorAll('.card, .art-card, .page-hero').forEach((element) => {
            element.classList.add('tilt-card');
        });

        document.querySelectorAll('main > section + section').forEach((section) => {
            const band = document.createElement('div');
            band.className = 'decor-band';
            band.setAttribute('aria-hidden', 'true');
            section.parentNode.insertBefore(band, section);
        });

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('[data-reveal]').forEach((element) => revealObserver.observe(element));

        function updateReadingProgress() {
            const scrollable = document.documentElement.scrollHeight - window.innerHeight;
            const progress = scrollable > 0 ? window.scrollY / scrollable : 0;
            document.documentElement.style.setProperty('--scroll-progress', Math.min(progress, 1));
        }

        updateReadingProgress();
        window.addEventListener('scroll', updateReadingProgress, { passive: true });

        const spotlight = document.getElementById('spotlight');
        const spotlightInput = document.getElementById('spotlight-input');
        const spotlightItems = Array.from(document.querySelectorAll('.spotlight-item'));
        const spotlightEmpty = document.getElementById('spotlight-empty');

        function openSpotlight() {
            spotlight.classList.add('is-open');
            document.body.style.overflow = 'hidden';
            spotlightInput.value = '';
            filterSpotlight('');
            window.setTimeout(() => spotlightInput.focus(), 50);
        }

        function closeSpotlight() {
            spotlight.classList.remove('is-open');
            document.body.style.overflow = '';
        }

        function filterSpotlight(query) {
            const normalizedQuery = query.trim().toLowerCase();
            let visibleCount = 0;
            spotlightItems.forEach((item) => {
                const haystack = item.dataset.search.toLowerCase();
                const isVisible = !normalizedQuery || haystack.includes(normalizedQuery);
                item.style.display = isVisible ? 'flex' : 'none';
                item.classList.toggle('is-active', visibleCount === 0 && isVisible);
                if (isVisible) {
                    visibleCount++;
                }
            });
            spotlightEmpty.style.display = visibleCount ? 'none' : 'block';
        }

        document.getElementById('open-spotlight').addEventListener('click', openSpotlight);
        document.getElementById('close-spotlight').addEventListener('click', closeSpotlight);
        spotlight.addEventListener('click', (event) => {
            if (event.target === spotlight) {
                closeSpotlight();
            }
        });
        spotlightInput.addEventListener('input', (event) => filterSpotlight(event.target.value));
        spotlightInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                const activeItem = spotlightItems.find((item) => item.classList.contains('is-active') && item.style.display !== 'none');
                if (activeItem) {
                    window.location.href = activeItem.href;
                }
            }
        });

        document.addEventListener('keydown', (event) => {
            const isSearchShortcut = (event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k';
            if (isSearchShortcut) {
                event.preventDefault();
                openSpotlight();
            }
            if (event.key === 'Escape' && spotlight.classList.contains('is-open')) {
                closeSpotlight();
            }
        });

        document.getElementById('toggle-reader-focus').addEventListener('click', () => {
            document.body.classList.toggle('reader-focus');
        });

        document.getElementById('scroll-top').addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        if (window.matchMedia('(pointer: fine)').matches) {
            window.addEventListener('pointermove', (event) => {
                document.documentElement.style.setProperty('--cursor-x', `${event.clientX}px`);
                document.documentElement.style.setProperty('--cursor-y', `${event.clientY}px`);
            }, { passive: true });

            document.querySelectorAll('.tilt-card').forEach((card) => {
                card.addEventListener('pointermove', (event) => {
                    const rect = card.getBoundingClientRect();
                    const x = ((event.clientX - rect.left) / rect.width - .5) * 4;
                    const y = ((event.clientY - rect.top) / rect.height - .5) * -4;
                    card.style.setProperty('--tilt-x', `${x}deg`);
                    card.style.setProperty('--tilt-y', `${y}deg`);
                });
                card.addEventListener('pointerleave', () => {
                    card.style.setProperty('--tilt-x', '0deg');
                    card.style.setProperty('--tilt-y', '0deg');
                });
            });
        }

        function launchHearts(button) {
            const rect = button.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            for (let index = 0; index < 13; index++) {
                const heart = document.createElement('span');
                heart.className = 'heart-burst';
                heart.textContent = index % 3 === 0 ? '\u2764' : '\u2665';
                heart.style.setProperty('--x', `${centerX + (Math.random() * 56 - 28)}px`);
                heart.style.setProperty('--y', `${centerY + (Math.random() * 18 - 9)}px`);
                heart.style.setProperty('--dx', `${Math.random() * 140 - 70}px`);
                heart.style.animationDelay = `${index * 35}ms`;
                document.body.appendChild(heart);
                window.setTimeout(() => heart.remove(), 1200);
            }
        }

        document.querySelectorAll('form[action*="/like"]').forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (form.dataset.likedAnimationDone === '1') {
                    return;
                }
                const button = form.querySelector('button');
                if (!button) {
                    return;
                }
                event.preventDefault();
                form.dataset.likedAnimationDone = '1';
                button.disabled = true;
                launchHearts(button);
                window.setTimeout(() => form.submit(), 620);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
