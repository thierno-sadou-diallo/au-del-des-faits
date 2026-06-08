@extends('frontend.layout')

@section('content')
<section class="home-hero text-white">
    <div class="row align-items-center g-5 home-hero-grid">
        <div class="col-lg-7">
            <span class="section-kicker text-sky">Blog sociologique & médias</span>
            <h1 class="attention-line" aria-label="Comprendre le monde au-delà des faits">
                <span>Comprendre le monde</span>
                <strong>au-delà des faits</strong>
            </h1>
            <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                <a href="{{ route('blog.index') }}" class="btn btn-light btn-lg">Lire les articles</a>
                <a href="#newsletter-home" class="btn btn-subscribe btn-lg">
                    <i class="fas fa-envelope-open-text me-2"></i>Abonner
                </a>
                <a href="https://youtube.com/@audeladesfaits24?si=rwrvJvKqaD1H1K9g" class="btn btn-youtube btn-lg" target="_blank" rel="noopener">
                    <i class="fab fa-youtube me-2"></i> YouTube
                </a>
            </div>
        </div>
        <div class="col-lg-5">
            <picture class="hero-portrait">
                <source srcset="{{ asset('images/ADF_me.webp') }}" type="image/webp">
                <img src="{{ asset('images/ADF_me.jpg') }}" alt="Halimatou Keita, fondatrice du blog Au-delà des faits" width="720" height="720" fetchpriority="high" decoding="async">
            </picture>
        </div>
    </div>
</section>

<section class="home-section subscribe-panel" id="newsletter-home">
    <div class="row align-items-center g-4">
        <div class="col-lg-6">
            <span class="section-kicker text-sky">Abonnement</span>
            <h2>Recevoir les nouvelles publications</h2>
            <p>Inscrivez-vous pour etre informe lorsqu'une nouvelle analyse ou publication de blog est disponible.</p>
        </div>
        <div class="col-lg-6">
            <form method="POST" action="{{ route('newsletter.subscribe') }}" class="subscribe-form">
                @csrf
                <input type="text" name="name" class="form-control" placeholder="Votre nom">
                <input type="email" name="email" class="form-control" placeholder="Votre email" required>
                <button class="btn btn-light" type="submit">S'abonner</button>
            </form>
        </div>
    </div>
</section>

<section class="home-section">
    <div class="row g-4 align-items-stretch">
        <div class="col-lg-7">
            <div class="home-panel h-100">
                <span class="section-kicker">Mission</span>
                <h2>Comprendre pour éveiller les consciences</h2>
                <p>
                    Au-delà des faits met la communication et l'analyse sociologique au service
                    de l'intérêt général. Le site donne des clés pour lire les injustices
                    banalisées, questionner les normes sociales et ouvrir une discussion utile.
                </p>
                <div class="pill-list" aria-label="Thèmes principaux">
                    <span>Justice sociale</span>
                    <span>Droits humains</span>
                    <span>Sénégal</span>
                    <span>Afrique</span>
                    <span>Éducation</span>
                    <span>Médias</span>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="home-panel h-100 founder-panel">
                <span class="section-kicker">Fondatrice</span>
                <h2>Halimatou Keita</h2>
                <p>
                    Sociologue de la famille et de l'éducation, étudiante en communication et
                    relations publiques, Halimatou Keita écrit pour rendre visibles les réalités
                    sociales qui touchent le quotidien des individus.
                </p>
                <a href="{{ route('about') }}" class="btn btn-outline-primary">Découvrir le parcours</a>
            </div>
        </div>
    </div>
</section>

<section class="home-section">
    <div class="section-head">
        <div>
            <span class="section-kicker">Dernières publications</span>
            <h2>Analyses récentes</h2>
            <p>Des lectures accessibles, documentées et pensées pour nourrir le débat public.</p>
        </div>
        <a href="{{ route('blog.index') }}" class="btn btn-outline-primary">Tous les articles</a>
    </div>

    <div class="row g-4">
        @forelse($recentPosts->take(3) as $post)
            <div class="col-lg-4">
                <article class="card content-card h-100">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" loading="lazy" decoding="async">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                            @if($post->category)
                                <span class="badge">{{ $post->category->name }}</span>
                            @endif
                            <small class="text-muted">{{ $post->created_at->format('d M Y') }}</small>
                        </div>
                        <h3>{{ $post->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 135) }}</p>
                        <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary mt-auto">Lire l'article</a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Aucun article disponible pour le moment.</div>
            </div>
        @endforelse
    </div>
</section>

<section class="home-section youtube-section">
    <div class="row g-4 align-items-center">
        <div class="col-lg-7">
            <span class="section-kicker text-sky">Vidéos & interventions</span>
            <h2>Suivre Au-delà des faits sur YouTube</h2>
            <p>
                Retrouvez les contenus audiovisuels, interventions et formats courts pour prolonger
                les analyses du blog en vidéo.
            </p>
        </div>
        <div class="col-lg-5 text-lg-end">
            <a href="https://youtube.com/@audeladesfaits24?si=rwrvJvKqaD1H1K9g" class="btn btn-light btn-lg" target="_blank" rel="noopener">
                <i class="fab fa-youtube me-2 text-danger"></i> Ouvrir la chaîne
            </a>
        </div>
    </div>
</section>

<section class="home-section">
    <div class="section-head">
        <div>
            <span class="section-kicker">Médias & projets</span>
            <h2>Une vitrine vivante</h2>
            <p>Photos, vidéos, interventions et réalisations publiées depuis l'administration.</p>
        </div>
        <a href="{{ route('portfolio.index') }}" class="btn btn-outline-primary">Explorer</a>
    </div>

    <div class="row g-4">
        @forelse($featuredProjects->take(3) as $project)
            <div class="col-lg-4">
                <article class="card content-card h-100">
                    @if(!empty($project->images[0]))
                        <img src="{{ asset('storage/'.$project->images[0]) }}" class="card-img-top" alt="{{ $project->title }}" loading="lazy" decoding="async">
                    @endif
                    <div class="card-body d-flex flex-column">
                        @if($project->category)
                            <span class="badge align-self-start mb-3">{{ $project->category->name }}</span>
                        @endif
                        <h3>{{ $project->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($project->description, 125) }}</p>
                        <a href="{{ route('portfolio.show', $project->slug) }}" class="btn btn-outline-primary mt-auto">Voir le média</a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Aucun média disponible pour le moment.</div>
            </div>
        @endforelse
    </div>
</section>

<section class="home-section stats-strip" aria-label="Statistiques du site">
    <div>
        <strong>{{ $stats['posts'] ?? $recentPosts->count() }}</strong>
        <span>Articles</span>
    </div>
    <div>
        <strong>{{ $stats['media'] ?? 0 }}</strong>
        <span>Médias</span>
    </div>
    <div>
        <strong>{{ $stats['comments'] ?? 0 }}</strong>
        <span>Échanges</span>
    </div>
    <div>
        <strong>{{ $stats['likes'] ?? 0 }}</strong>
        <span>Interactions</span>
    </div>
</section>
@endsection

@push('styles')
<style>
    .home-hero {
        background:
            linear-gradient(135deg, rgba(2, 6, 23, .97), rgba(15, 23, 42, .92) 52%, rgba(30, 64, 175, .82)),
            radial-gradient(circle at 85% 20%, rgba(56, 189, 248, .3), transparent 18rem);
        border-radius: 24px;
        margin-bottom: 4rem;
        overflow: hidden;
        padding: clamp(2rem, 5vw, 4.5rem);
        position: relative;
    }

    .home-hero::before {
        background:
            linear-gradient(90deg, rgba(2, 6, 23, .62), transparent 70%),
            radial-gradient(circle at 18% 35%, rgba(125, 211, 252, .18), transparent 16rem);
        content: "";
        inset: 0;
        pointer-events: none;
        position: absolute;
        z-index: 0;
    }

    .home-hero .col-lg-7,
    .home-hero .col-lg-5 {
        position: relative;
        z-index: 1;
    }

    .home-hero .col-lg-7 {
        z-index: 3;
    }

    .attention-line {
        background:
            linear-gradient(135deg, rgba(2, 6, 23, .78), rgba(15, 23, 42, .48)),
            radial-gradient(circle at 10% 10%, rgba(125, 211, 252, .22), transparent 14rem);
        border: 1px solid rgba(255, 255, 255, .18);
        border-left: 5px solid #7dd3fc;
        border-radius: 24px;
        box-shadow: 0 28px 80px rgba(2, 6, 23, .34);
        display: block;
        margin: 1.15rem 0 0;
        max-width: 650px;
        overflow: hidden;
        padding: clamp(1.35rem, 2.6vw, 2rem);
        position: relative;
    }

    .attention-line::before {
        background: linear-gradient(90deg, #f59e0b, #7dd3fc, #fff);
        content: "";
        height: 3px;
        left: clamp(1.25rem, 3vw, 2.25rem);
        position: absolute;
        right: clamp(1.25rem, 3vw, 2.25rem);
        top: 0;
    }

    .attention-line span,
    .attention-line strong {
        animation: attention-rise .9s ease both, attention-glow 4s ease-in-out infinite;
        color: #fff;
        display: inline-block;
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.25rem, 5.4vw, 4.9rem);
        font-weight: 900;
        letter-spacing: 0;
        line-height: 1.04;
        padding-block: .1em;
        text-shadow: 0 18px 44px rgba(2, 6, 23, .78);
    }

    .attention-line span {
        display: block;
    }

    .attention-line strong {
        animation-delay: .16s, .4s;
        background: linear-gradient(92deg, #fef3c7 0%, #7dd3fc 46%, #fff 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        position: relative;
    }

    .attention-line strong::after {
        animation: attention-sweep 3.2s ease-in-out infinite;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.82), transparent);
        content: "";
        inset: 0;
        position: absolute;
        transform: translateX(-120%) skewX(-18deg);
    }

    @keyframes attention-rise {
        from {
            opacity: 0;
            transform: translateY(22px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes attention-glow {
        0%, 100% {
            filter: drop-shadow(0 0 0 rgba(125, 211, 252, 0));
        }
        50% {
            filter: drop-shadow(0 0 16px rgba(125, 211, 252, .34));
        }
    }

    @keyframes attention-sweep {
        0%, 42% {
            transform: translateX(-120%) skewX(-18deg);
        }
        70%, 100% {
            transform: translateX(130%) skewX(-18deg);
        }
    }

    .hero-lead {
        color: rgba(241, 245, 249, .9) !important;
        font-size: clamp(1.1rem, 2vw, 1.35rem);
        max-width: 720px;
    }

    .text-sky {
        color: #7dd3fc;
    }

    .btn-youtube {
        background: #dc2626;
        border-color: #dc2626;
        color: #fff;
    }

    .btn-youtube:hover {
        background: #b91c1c;
        border-color: #b91c1c;
        color: #fff;
    }

    .btn-subscribe {
        background: #f59e0b;
        border-color: #f59e0b;
        color: #020617;
        font-weight: 900;
    }

    .btn-subscribe:hover {
        background: #fbbf24;
        border-color: #fbbf24;
        color: #020617;
    }

    .subscribe-panel {
        background:
            linear-gradient(135deg, #020617, #1e293b 58%, #0f766e),
            radial-gradient(circle at 12% 18%, rgba(245, 158, 11, .25), transparent 16rem);
        border-radius: 22px;
        color: #fff;
        padding: clamp(1.5rem, 4vw, 2.5rem);
    }

    .subscribe-panel h2 {
        color: #fff;
        font-size: clamp(1.9rem, 4vw, 3rem);
        margin: .6rem 0 1rem;
    }

    .subscribe-panel p {
        color: rgba(241, 245, 249, .86) !important;
        margin-bottom: 0;
    }

    .subscribe-form {
        display: grid;
        gap: .75rem;
        grid-template-columns: 1fr 1.1fr auto;
    }

    .subscribe-form .form-control {
        border: 1px solid rgba(255, 255, 255, .28);
        border-radius: 999px;
        min-height: 52px;
        padding-inline: 1rem;
    }

    .subscribe-form .btn {
        border-radius: 999px;
        font-weight: 900;
        min-height: 52px;
        padding-inline: 1.25rem;
        white-space: nowrap;
    }

    .hero-portrait {
        aspect-ratio: 1 / 1;
        border: 1px solid rgba(255, 255, 255, .22);
        border-radius: 24px;
        box-shadow: 0 28px 70px rgba(2, 6, 23, .34);
        display: block;
        margin-left: auto;
        max-width: 400px;
        overflow: hidden;
        position: relative;
    }

    .hero-portrait::after {
        background: linear-gradient(90deg, rgba(2, 6, 23, .28), transparent 48%);
        content: "";
        inset: 0;
        position: absolute;
    }

    .hero-portrait img {
        height: 100%;
        object-fit: cover;
        width: 100%;
    }

    .home-section {
        margin: 4rem 0;
    }

    .home-panel {
        background: rgba(255, 255, 255, .86);
        border: 1px solid rgba(148, 163, 184, .22);
        border-radius: 18px;
        box-shadow: 0 18px 48px rgba(15, 23, 42, .08);
        padding: clamp(1.5rem, 3vw, 2.5rem);
    }

    .home-panel h2,
    .section-head h2,
    .youtube-section h2 {
        font-size: clamp(2rem, 4vw, 3.4rem);
        margin: .6rem 0 1rem;
    }

    .founder-panel {
        background:
            linear-gradient(180deg, rgba(255, 255, 255, .94), rgba(239, 246, 255, .9)),
            radial-gradient(circle at 100% 0, rgba(245, 158, 11, .14), transparent 14rem);
    }

    .pill-list {
        display: flex;
        flex-wrap: wrap;
        gap: .7rem;
        margin-top: 1.5rem;
    }

    .pill-list span {
        background: #0f172a;
        border-radius: 999px;
        color: #fff;
        font-size: .9rem;
        font-weight: 800;
        padding: .65rem .9rem;
    }

    .section-head {
        align-items: end;
        display: flex;
        gap: 1rem;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .section-head p {
        margin-bottom: 0;
        max-width: 760px;
    }

    .content-card {
        border: 1px solid rgba(148, 163, 184, .22);
        border-radius: 16px;
        overflow: hidden;
    }

    .content-card .card-img-top {
        aspect-ratio: 16 / 10;
        object-fit: cover;
    }

    .content-card h3 {
        font-size: 1.35rem;
        line-height: 1.2;
    }

    .youtube-section {
        background:
            linear-gradient(135deg, #111827, #1e293b 56%, #7f1d1d),
            radial-gradient(circle at 10% 20%, rgba(248, 113, 113, .28), transparent 16rem);
        border-radius: 22px;
        color: #fff;
        padding: clamp(1.75rem, 4vw, 3rem);
    }

    .youtube-section h2 {
        color: #fff;
    }

    .youtube-section p {
        color: rgba(241, 245, 249, .88) !important;
        margin-bottom: 0;
    }

    .stats-strip {
        background: #020617;
        border-radius: 18px;
        display: grid;
        gap: 1px;
        grid-template-columns: repeat(4, 1fr);
        overflow: hidden;
    }

    .stats-strip div {
        background: rgba(255, 255, 255, .06);
        color: #fff;
        padding: 1.35rem;
        text-align: center;
    }

    .stats-strip strong {
        display: block;
        font-size: clamp(1.8rem, 4vw, 3rem);
        line-height: 1;
    }

    .stats-strip span {
        color: rgba(226, 232, 240, .78);
        font-weight: 800;
        text-transform: uppercase;
        font-size: .75rem;
        letter-spacing: .12em;
    }

    @media (max-width: 767px) {
        .attention-line {
            border-radius: 20px;
            padding: 1.35rem;
        }

        .attention-line span,
        .attention-line strong {
            font-size: clamp(2rem, 11vw, 3.35rem);
        }

        .section-head {
            align-items: flex-start;
            flex-direction: column;
        }

        .stats-strip {
            grid-template-columns: repeat(2, 1fr);
        }

        .subscribe-form {
            grid-template-columns: 1fr;
        }
    }

    @media (min-width: 992px) {
        .home-hero-grid {
            --bs-gutter-x: 4.5rem;
        }

        .home-hero .col-lg-7 {
            flex: 0 0 auto;
            width: 58%;
        }

        .home-hero .col-lg-5 {
            flex: 0 0 auto;
            width: 42%;
        }
    }
</style>
@endpush
