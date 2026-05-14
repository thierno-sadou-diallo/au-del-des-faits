@extends('frontend.layout')

@section('content')
<section class="page-hero p-4 p-lg-5 mb-5 african-decor">
    <div class="row align-items-center g-5">
        <div class="col-lg-7">
            <span class="badge mb-3">Services</span>
            <h1 class="display-3 fw-bold mb-4">Accompagnement sociologique, clair et engage.</h1>
            <p class="lead mb-4">Des etudes, conseils et contenus concus pour aider les institutions, ONG, medias et organisations a mieux comprendre les dynamiques sociales.</p>
            <div class="d-flex flex-column flex-sm-row gap-3">
                <a href="{{ route('contact') }}" class="btn btn-light btn-lg">Demander un accompagnement</a>
                <a href="{{ route('medias') }}" class="btn btn-outline-light btn-lg">Voir les medias</a>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="service-art-panel">
                <img src="{{ asset('images/ADF.jpg') }}" alt="Illustration services" class="service-art-image">
                <div class="service-chip chip-two">Conseil</div>
                <div class="service-chip chip-three">Medias</div>
            </div>
        </div>
    </div>
</section>

<section class="mb-6 mt-6">
    <div class="row align-items-end mb-4">
        <div class="col-lg-8">
            <span class="badge mb-3">Service</span>
            <h2 class="display-5 fw-bold">Service:</h2>
            <p class="lead text-muted">COMMUNICATION ET RELATIONS PUBLIQUES, RÉDACTION D'ARTICLES, GESTION DE RÉSEAUX SOCIAUX, COORDINATION D’ÉVÉNEMENTS et plus encore pour accompagner vos besoins.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <article class="card service-detail-card service-card-1 animate-on-scroll">
                <div class="card-body">
                    <div class="service-icon"><i class="fas fa-bullhorn"></i></div>
                    <h3 class="h4 fw-bold">COMMUNICATION ET RELATIONS PUBLIQUES</h3>
                    <p>Offrir des services d'audit et d'élaboration de plans de communication et/ ou de marketing efficaces aux organisations et aux individus afin de vous aider à atteindre vos objectifs de communication que cela soit pour un renfoncement de la notoriété de votre marque, pour la préservation ou le renfoncement de votre positionnement, pour la consolidation des liens avec vos publics cibles, pour une gestion de crise, une communication événementielle ou pour une rentabilité de votre business, pour l'acquisition de nouveaux sponsors etc…</p>
                </div>
            </article>
        </div>
        <div class="col-lg-6">
            <article class="card service-detail-card service-card-2 animate-on-scroll">
                <div class="card-body">
                    <div class="service-icon"><i class="fas fa-pen-fancy"></i></div>
                    <h3 class="h4 fw-bold">RÉDACTION D'ARTICLES</h3>
                    <p>Proposer des services de rédaction de communiqué presse, de lettre d'opinion, de dossiers de presse, de pitch de vente pour produits et services, d'allocution pour vos discours, d'articles pour les blogs, les sites web, les publications imprimées et autres plateformes médiatiques. Nous nous assurerons de mettre à votre disposition des contenus de qualité sur une variété de sujets dans le respect les normes éditoriales.</p>
                </div>
            </article>
        </div>
        <div class="col-lg-6">
            <article class="card service-detail-card service-card-3 animate-on-scroll">
                <div class="card-body">
                    <div class="service-icon"><i class="fas fa-share-alt"></i></div>
                    <h3 class="h4 fw-bold">GESTION DE RÉSEAUX SOCIAUX</h3>
                    <p>Offrir des services de gestion et d'animation des réseaux sociaux afin d'améliorer votre visibilité en ligne, renforcer votre image de marque et développer une communauté engagée autour de vos activités. Élaborer des stratégies de contenu adaptées à vos objectifs, créer des publications attractives et pertinentes, assurer l'interaction avec votre audience et analyser les performances de vos plateformes numériques afin d'optimiser votre communication digitale.</p>
                </div>
            </article>
        </div>
        <div class="col-lg-6">
            <article class="card service-detail-card service-card-4 animate-on-scroll">
                <div class="card-body">
                    <div class="service-icon"><i class="fas fa-calendar-alt"></i></div>
                    <h3 class="h4 fw-bold">COORDINATION D'ÉVÉNEMENTS</h3>
                    <p>Proposer des services de planification, d'organisation et de coordination d'événements professionnels, éducatifs, sociaux et communautaires. Assurer la gestion logistique, la communication événementielle, la coordination des intervenants et partenaires, ainsi que le suivi des différentes étapes nécessaires à la réussite de vos événements. Veiller à créer des expériences enrichissantes et impactantes adaptées à vos objectifs et à votre public cible.</p>
                </div>
            </article>
        </div>
        <div class="col-lg-6">
            <article class="card service-detail-card service-card-5 animate-on-scroll">
                <div class="card-body">
                    <div class="service-icon"><i class="fas fa-newspaper"></i></div>
                    <h3 class="h4 fw-bold">GESTION DE LA RELATION PRESSE</h3>
                    <p>Offrir des services de gestion des relations avec les médias afin d'accroître votre visibilité et valoriser votre image publique. Assurer la rédaction et la diffusion de communiqués de presse, la prise de contact avec les journalistes et organes de presse, l'organisation d'interviews et de conférences de presse, ainsi que le développement de stratégies médiatiques efficaces pour promouvoir vos activités, projets, événements ou prises de position publiques.</p>
                </div>
            </article>
        </div>
        <div class="col-lg-6">
            <article class="card service-detail-card service-card-6 animate-on-scroll">
                <div class="card-body">
                    <div class="service-icon"><i class="fas fa-balance-scale"></i></div>
                    <h3 class="h4 fw-bold">PROMOTION DE LA JUSTICE SOCIALE</h3>
                    <p>Engager dans des services visant à sensibiliser, éduquer et promouvoir la justice sociale par la mise en lumière des injustices et des inégalités dans la société et en travaillant pour les adresser de manière proactive. Apporter un soutien aux individus et aux groupes affectés par les inégalités sociales.</p>
                </div>
            </article>
        </div>
        <div class="col-lg-6">
            <article class="card service-detail-card service-card-7 animate-on-scroll">
                <div class="card-body">
                    <div class="service-icon"><i class="fas fa-user-friends"></i></div>
                    <h3 class="h4 fw-bold">CONSULTATION ET CONSEIL</h3>
                    <p>Offrir des services de consultation et de conseil dans les domaines de la sociologie, de la communication et relations publiques et de la justice sociale, en vous fournissant des conseils personnalisés et des recommandations basées sur une expertise approfondie dans ces domaines. Proposer un éventail de services axés sur la consultation et la résolution de problèmes familiaux, ainsi que sur la résolution des défis rencontrés dans l'éducation des enfants par les parents, les enseignants et les enfants eux-mêmes.</p>
                </div>
            </article>
        </div>
        <div class="col-lg-6">
            <article class="card service-detail-card service-card-8 animate-on-scroll">
                <div class="card-body">
                    <div class="service-icon"><i class="fas fa-heart"></i></div>
                    <h3 class="h4 fw-bold">ASSISTANCE PSYCHOLOGIQUE</h3>
                    <p>Offrir un service d'assistance psychologique dédié aux personnes traversant des périodes difficiles. Qu'il s'agisse des défis émotionnels, des conflits relationnels, des situations de stress intense ou des moments de crise personnelle, je suis là pour apporter mon soutien. Mon approche bienveillante et professionnelle vise à vous aider à surmonter ces épreuves en vous fournissant les outils nécessaires pour retrouver un équilibre et un bien-être émotionnel. Ensemble, nous travaillerons à développer des stratégies adaptées à vos besoins pour vous permettre de naviguer ces moments complexes avec plus de sérénité et de résilience.</p>
                </div>
            </article>
        </div>
    </div>
        <div class="col-12">
            <article class="card service-detail-card">
                <div class="card-body">
                    <h3 class="h4 fw-bold">GESTION DE RÉSEAUX SOCIAUX</h3>
                    <p>Offrir des services de gestion et d’animation des réseaux sociaux afin d’améliorer votre visibilité en ligne, renforcer votre image de marque et développer une communauté engagée autour de vos activités. Élaborer des stratégies de contenu adaptées à vos objectifs, créer des publications attractives et pertinentes, assurer l’interaction avec votre audience et analyser les performances de vos plateformes numériques afin d’optimiser votre communication digitale.</p>
                </div>
            </article>
        </div>
        <div class="col-12">
            <article class="card service-detail-card">
                <div class="card-body">
                    <h3 class="h4 fw-bold">COORDINATION D’ÉVÉNEMENTS</h3>
                    <p>Proposer des services de planification, d’organisation et de coordination d’événements professionnels, éducatifs, sociaux et communautaires. Assurer la gestion logistique, la communication événementielle, la coordination des intervenants et partenaires, ainsi que le suivi des différentes étapes nécessaires à la réussite de vos événements. Veiller à créer des expériences enrichissantes et impactantes adaptées à vos objectifs et à votre public cible.</p>
                </div>
            </article>
        </div>
        <div class="col-12">
            <article class="card service-detail-card">
                <div class="card-body">
                    <h3 class="h4 fw-bold">GESTION DE LA RELATION PRESSE</h3>
                    <p>Offrir des services de gestion des relations avec les médias afin d’accroître votre visibilité et valoriser votre image publique. Assurer la rédaction et la diffusion de communiqués de presse, la prise de contact avec les journalistes et organes de presse, l’organisation d’interviews et de conférences de presse, ainsi que le développement de stratégies médiatiques efficaces pour promouvoir vos activités, projets, événements ou prises de position publiques.</p>
                </div>
            </article>
        </div>
        <div class="col-12">
            <article class="card service-detail-card">
                <div class="card-body">
                    <h3 class="h4 fw-bold">PROMOTION DE LA JUSTICE SOCIALE</h3>
                    <p>Engager dans des services visant à sensibiliser, éduquer et promouvoir la justice sociale par la mise en lumière des injustices et des inégalités dans la société et en travaillant pour les adresser de manière proactive. Apporter un soutien aux individus et aux groupes affectés par les inégalités sociales.</p>
                </div>
            </article>
        </div>
        <div class="col-12">
            <article class="card service-detail-card">
                <div class="card-body">
                    <h3 class="h4 fw-bold">CONSULTATION ET CONSEIL</h3>
                    <p>Offrir des services de consultation et de conseil dans les domaines de la sociologie, de la communication et relations publiques et de la justice sociale, en vous fournissant des conseils personnalisés et des recommandations basées sur une expertise approfondie dans ces domaines. Proposer un éventail de services axés sur la consultation et la résolution de problèmes familiaux, ainsi que sur la résolution des défis rencontrés dans l'éducation des enfants par les parents, les enseignants et les enfants eux-mêmes.</p>
                </div>
            </article>
        </div>
        <div class="col-12">
            <article class="card service-detail-card">
                <div class="card-body">
                    <h3 class="h4 fw-bold">ASSISTANCE PSYCHOLOGIQUE</h3>
                    <p>Offrir un service d'assistance psychologique dédié aux personnes traversant des périodes difficiles. Qu’il s’agisse des défis émotionnels, des conflits relationnels, des situations de stress intense ou des moments de crise personnelle, je suis là pour apporter mon soutien. Mon approche bienveillante et professionnelle vise à vous aider à surmonter ces épreuves en vous fournissant les outils nécessaires pour retrouver un équilibre et un bien-être émotionnel. Ensemble, nous travaillerons à développer des stratégies adaptées à vos besoins pour vous permettre de naviguer ces moments complexes avec plus de sérénité et de résilience.</p>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="text-center page-hero p-4 p-lg-5 mb-6 mt-6">
    <span class="badge mb-3">Projet</span>
    <h2 class="display-5 fw-bold">Discutons de votre besoin.</h2>
    <p class="lead mx-auto mb-4" style="max-width: 760px;">Chaque mission est unique. Le premier echange sert a clarifier vos objectifs et proposer une approche adaptee.</p>
    <a href="{{ route('contact') }}" class="btn btn-light btn-lg">Me contacter</a>
</section>
@endsection

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');
    .service-art-panel {
        aspect-ratio: 1 / 1;
        border-radius: 32px;
        min-height: 360px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 32px 90px rgba(2, 6, 23, .28);
        border: 1px solid rgba(255,255,255,.18);
    }
    .service-art-panel::before {
        background: radial-gradient(circle at 18% 18%, rgba(56,189,248,.24), transparent 28%);
        content: "";
        inset: 0;
        position: absolute;
        pointer-events: none;
    }
    .service-art-image {
        height: 100%;
        object-fit: cover;
        width: 100%;
        filter: contrast(1.05) saturate(1.05);
    }
    .service-chip {
        background: rgba(255,255,255,.94);
        border-radius: 999px;
        color: #020617;
        font-weight: 700;
        padding: .65rem 1rem;
        position: absolute;
        text-transform: uppercase;
        box-shadow: 0 16px 40px rgba(2,6,23,.16);
    }
    .chip-one { top: 18%; left: 16%; }
    .chip-two { bottom: 20%; right: 18%; }
    .chip-three { top: 56%; right: 10%; }
    .service-marquee {
        background: #020617;
        border-radius: 18px;
        box-shadow: 0 18px 50px rgba(15,23,42,.16);
        color: #fff;
        overflow: hidden;
    }
    .service-marquee-track {
        animation: service-scroll 26s linear infinite;
        display: inline-flex;
        gap: 2rem;
        padding: 1rem 0;
        white-space: nowrap;
    }
    .service-marquee span {
        color: rgba(226,232,240,.9);
        font-weight: 900;
        text-transform: uppercase;
    }
    .service-card .card-body { padding: 2rem; }
    .service-icon {
        align-items: center;
        background: linear-gradient(135deg, #020617, #2563eb);
        border-radius: 18px;
        color: #fff;
        display: inline-flex;
        font-size: 1.35rem;
        height: 56px;
        justify-content: center;
        margin-bottom: 1.25rem;
        width: 56px;
    }
    .service-list {
        display: grid;
        gap: .7rem;
        list-style: none;
        margin: 1.25rem 0 0;
        padding: 0;
    }
    .service-list li {
        align-items: center;
        display: flex;
        font-weight: 700;
    }
    .service-list li::before {
        background: #38bdf8;
        border-radius: 999px;
        content: "";
        height: 8px;
        margin-right: .8rem;
        width: 8px;
    }
    .service-detail-card {
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.16);
        border-radius: 28px;
        box-shadow: 0 28px 80px rgba(2,6,23,.18);
        backdrop-filter: blur(10px);
        transition: all .3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    .service-detail-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(56,189,248,.1), transparent);
        transition: left .5s;
    }
    .service-detail-card:hover::before {
        left: 100%;
    }
    .service-detail-card:hover {
        border-color: rgba(56,189,248,.4);
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 40px 120px rgba(2,6,23,.3);
    }
    .service-detail-card .card-body {
        padding: 2.2rem;
        position: relative;
        z-index: 2;
    }
    .service-detail-card h3 {
        letter-spacing: .03em;
        margin-bottom: 1rem;
        text-transform: uppercase;
        font-size: 1.1rem;
        color: #020617;
        font-weight: 700;
        font-family: 'Montserrat', sans-serif;
    }
    .service-detail-card p {
        color: rgba(226,232,240,.88);
        margin-bottom: 0;
        line-height: 1.85;
        font-size: .95rem;
    }
    .service-icon {
        align-items: center;
        background: linear-gradient(135deg, #020617, #2563eb);
        border-radius: 18px;
        color: #fff;
        display: inline-flex;
        font-size: 1.35rem;
        height: 56px;
        justify-content: center;
        margin-bottom: 1.25rem;
        width: 56px;
        transition: transform .3s ease, background .3s ease;
    }
    .service-detail-card:hover .service-icon {
        transform: scale(1.1) rotate(5deg);
        background: linear-gradient(135deg, #2563eb, #38bdf8);
    }
    /* Specific card colors */
    .service-card-1 { border-left: 4px solid #38bdf8; }
    .service-card-2 { border-left: 4px solid #f59e0b; }
    .service-card-3 { border-left: 4px solid #10b981; }
    .service-card-4 { border-left: 4px solid #ef4444; }
    .service-card-5 { border-left: 4px solid #8b5cf6; }
    .service-card-6 { border-left: 4px solid #06b6d4; }
    .service-card-7 { border-left: 4px solid #f97316; }
    .service-card-8 { border-left: 4px solid #ec4899; }
    .service-card-1:hover { box-shadow: 0 40px 120px rgba(56,189,248,.2); }
    .service-card-2:hover { box-shadow: 0 40px 120px rgba(245,158,11,.2); }
    .service-card-3:hover { box-shadow: 0 40px 120px rgba(16,185,129,.2); }
    .service-card-4:hover { box-shadow: 0 40px 120px rgba(239,68,68,.2); }
    .service-card-5:hover { box-shadow: 0 40px 120px rgba(139,92,246,.2); }
    .service-card-6:hover { box-shadow: 0 40px 120px rgba(6,182,212,.2); }
    .service-card-7:hover { box-shadow: 0 40px 120px rgba(249,115,22,.2); }
    .service-card-8:hover { box-shadow: 0 40px 120px rgba(236,72,153,.2); }
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.6s ease-out forwards;
    }
    .animate-on-scroll:nth-child(1) { animation-delay: 0.1s; }
    .animate-on-scroll:nth-child(2) { animation-delay: 0.2s; }
    .animate-on-scroll:nth-child(3) { animation-delay: 0.3s; }
    .animate-on-scroll:nth-child(4) { animation-delay: 0.4s; }
    .animate-on-scroll:nth-child(5) { animation-delay: 0.5s; }
    .animate-on-scroll:nth-child(6) { animation-delay: 0.6s; }
    .animate-on-scroll:nth-child(7) { animation-delay: 0.7s; }
    .animate-on-scroll:nth-child(8) { animation-delay: 0.8s; }
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .timeline-flow {
        display: grid;
        gap: 1rem;
    }
    .timeline-flow > div {
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 18px;
        padding: 1.25rem;
    }
    .timeline-flow span {
        color: #38bdf8;
        font-weight: 900;
    }
    .timeline-flow h3 {
        color: #fff;
        font-size: 1.25rem;
        margin: .3rem 0;
    }
    .timeline-flow p {
        color: rgba(226,232,240,.86);
        margin: 0;
    }
    .sector-card {
        background: rgba(255,255,255,.76);
        border: 1px solid rgba(148,163,184,.24);
        border-radius: 20px;
        box-shadow: 0 18px 50px rgba(15,23,42,.08);
        height: 100%;
        padding: 2rem;
        transition: transform .24s ease, box-shadow .24s ease;
    }
    .sector-card:hover {
        box-shadow: 0 26px 70px rgba(15,23,42,.14);
        transform: translateY(-6px);
    }
    .sector-card i {
        color: #2563eb;
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    .sector-card h3 {
        font-size: 1.25rem;
    }
    @keyframes rotate-orbit {
        to { transform: rotate(360deg); }
    }
    @keyframes service-scroll {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }
</style>
@endpush
