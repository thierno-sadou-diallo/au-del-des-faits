@extends('frontend.layout')

@section('content')
<section class="page-hero p-4 p-lg-5 mb-6 african-decor">
    <span class="badge mb-3 d-block">Thématiques</span>
    <h1 class="display-3 fw-bold mb-3"><span class="gradient-text">Explorer les grands axes sociaux</span></h1>
    <p class="lead mx-auto" style="max-width: 760px;">Des sujets profonds, présentés avec clarté et rythme pour faciliter la lecture et donner envie d'aller plus loin.</p>
</section>

<section class="mb-6 mt-6">
    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <article class="card h-100 topic-card">
                <div class="card-body text-center">
                    <i class="fas fa-users"></i>
                    <h2 class="h4 fw-bold">Justice sociale</h2>
                    <p>Analyses des mécanismes d'inégalité, de discrimination et des politiques de justice sociale.</p>
                    <a href="{{ route('blog.index') }}" class="btn btn-primary">Voir les articles</a>
                </div>
            </article>
        </div>
        <div class="col-md-6 col-lg-3">
            <article class="card h-100 topic-card">
                <div class="card-body text-center">
                    <i class="fas fa-globe-africa"></i>
                    <h2 class="h4 fw-bold">Afrique contemporaine</h2>
                    <p>Regards croisés sur les transformations sociales, économiques et politiques du continent.</p>
                    <a href="{{ route('blog.index') }}" class="btn btn-primary">Voir les articles</a>
                </div>
            </article>
        </div>
        <div class="col-md-6 col-lg-3">
            <article class="card h-100 topic-card">
                <div class="card-body text-center">
                    <i class="fas fa-balance-scale"></i>
                    <h2 class="h4 fw-bold">Droits humains</h2>
                    <p>Défense des droits fondamentaux, libertés publiques et dignité dans l'espace social.</p>
                    <a href="{{ route('blog.index') }}" class="btn btn-primary">Voir les articles</a>
                </div>
            </article>
        </div>
        <div class="col-md-6 col-lg-3">
            <article class="card h-100 topic-card">
                <div class="card-body text-center">
                    <i class="fas fa-brain"></i>
                    <h2 class="h4 fw-bold">Méthodologie</h2>
                    <p>Outils d'analyse sociale, méthodes de recherche et perspectives théoriques en sociologie.</p>
                    <a href="{{ route('blog.index') }}" class="btn btn-primary">Voir les articles</a>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="page-hero p-4 p-lg-5 mb-6 mt-6">
    <div class="row g-4 align-items-center">
        <div class="col-lg-6">
            <span class="badge mb-3">Approche</span>
            <h2 class="display-5 fw-bold"><span class="gradient-text">Des sujets connectés entre eux.</span></h2>
            <p class="lead">Les enjeux contemporains se croisent : justice, économie, droits, médias, éducation, territoire. Le site invite à circuler entre ces thèmes sans perdre le fil.</p>
        </div>
        <div class="col-lg-6">
            <div class="theme-map">
                <span>Société</span>
                <span>Médias</span>
                <span>Dignité</span>
                <span>Afrique</span>
                <span>Recherche</span>
                <span>Dialogue</span>
            </div>
        </div>
    </div>
</section>

<section class="mb-6">
    <div class="row align-items-center g-4 african-decor">
        <div class="col-lg-6">
            <picture class="topic-image-card">
                <source srcset="{{ asset('images/ADF.webp') }}" type="image/webp">
                <img src="{{ asset('images/ADF.jpg') }}" alt="Illustration des thématiques" class="img-fluid rounded-4" loading="lazy" decoding="async">
            </picture>
        </div>
        <div class="col-lg-6">
            <span class="section-kicker">Visuel</span>
            <h2 class="display-6 fw-bold">Un univers visuel fort et moderne</h2>
            <p class="lead text-muted">Une ambiance qui associe rigueur sociologique et expression culturelle africaine, pour accompagner chaque thématique avec élégance.</p>
        </div>
    </div>
</section>

<div class="text-center">
    <a href="{{ route('blog.index') }}" class="btn btn-primary btn-lg">Tous les articles</a>
</div>
@endsection

@push('styles')
<style>
    .topic-card .card-body { padding: 2rem 1.4rem; }
    .topic-card i {
        align-items: center;
        background: linear-gradient(135deg, #020617, #2563eb);
        border-radius: 20px;
        color: #fff;
        display: inline-flex;
        font-size: 1.6rem;
        height: 64px;
        justify-content: center;
        margin-bottom: 1.25rem;
        width: 64px;
    }
    .theme-map {
        display: flex;
        flex-wrap: wrap;
        gap: .85rem;
    }
    .theme-map span {
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 999px;
        color: #fff;
        font-weight: 900;
        padding: .85rem 1rem;
    }
    .topic-image-card {
        background: linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,255,255,.76));
        border: 1px solid rgba(148, 163, 184, .24);
        border-radius: 28px;
        box-shadow: 0 24px 60px rgba(15, 23, 42, .12);
        display: block;
        overflow: hidden;
        padding: .5rem;
    }
    .topic-image-card img {
        display: block;
        height: auto;
        object-fit: cover;
        width: 100%;
    }
</style>
@endpush
