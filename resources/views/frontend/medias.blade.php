@extends('frontend.layout')

@section('content')
<section class="media-page-hero page-hero p-4 p-lg-5 mb-5 african-decor">
    <div class="row g-4 align-items-center">
        <div class="col-lg-7">
            <span class="badge bg-primary mb-3">Médias</span>
            <h1 class="display-4 fw-bold"><span class="gradient-text">Photos, vidéos et archives d'interventions</span></h1>
            <p class="lead text-secondary mt-3">Découvrez les médias publiés par l'administrateur : émissions, interviews, images de terrain et contenus audiovisuels.</p>
            <div class="media-pills mt-4">
                <span>Interviews</span>
                <span>Terrain</span>
                <span>Archives</span>
            </div>
        </div>
        <div class="col-lg-5">
            <picture class="media-hero-card rounded-4 overflow-hidden shadow-sm">
                <source srcset="{{ asset('images/ADF.webp') }}" type="image/webp">
                <img src="{{ asset('images/ADF.jpg') }}" alt="Médias visuels Au-delà des faits" class="img-fluid w-100" loading="lazy" decoding="async">
            </picture>
        </div>
    </div>
</section>

<div class="row gy-4">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-center">
                    <div class="col-12 col-sm-auto">
                        <label class="form-label mb-0" for="category">Catégorie</label>
                    </div>
                    <div class="col-12 col-sm">
                        <select id="category" name="category" onchange="this.form.submit()" class="form-select">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-auto">
                        <button type="submit" class="btn btn-primary">Filtrer</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 g-4">
            @forelse($mediaItems as $item)
                <div class="col">
                    <article class="card h-100 shadow-sm border-0">
                        @if($item->cover_image_url)
                            <img src="{{ $item->cover_image_url }}" class="card-img-top publication-thumb" alt="{{ $item->title }}" loading="lazy" decoding="async">
                        @else
                            <div class="publication-thumb publication-thumb-empty">
                                <i class="fas fa-photo-film"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                @if($item->category)
                                    <span class="badge bg-secondary">{{ $item->category->name }}</span>
                                @endif
                            </div>
                            <h2 class="h5 fw-bold"><a href="{{ route('medias.show', $item->slug) }}" class="text-dark text-decoration-none">{{ $item->title }}</a></h2>
                            <p class="text-muted">{{ \Illuminate\Support\Str::limit($item->excerpt, 110) }}</p>
                            <div class="mt-auto d-flex flex-wrap gap-2 align-items-center">
                                @if($item->video_url)
                                    <a href="{{ $item->video_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">Voir la vidéo</a>
                                @endif
                                <a href="{{ route('medias.show', $item->slug) }}" class="btn btn-sm btn-primary">Découvrir</a>
                                <small class="text-muted">{{ $item->likes ?? 0 }} likes</small>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-secondary">Aucun média disponible pour le moment.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">{{ $mediaItems->onEachSide(1)->links('frontend.partials.pagination') }}</div>
    </div>

    <aside class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Médias publiés</h5>
                <p class="text-muted">Une vitrine de photos, vidéos et interventions en lien avec la recherche sociologique et les activités publiques.</p>
            </div>
        </div>
    </aside>
</div>

@push('styles')
<style>
    .media-hero-card {
        background: linear-gradient(180deg, rgba(255,255,255,.94), rgba(239,246,255,.8));
        border: 1px solid rgba(148, 163, 184, .24);
        display: block;
        position: relative;
    }
    .media-hero-card::after {
        background: linear-gradient(180deg, transparent, rgba(2,6,23,.42));
        content: "";
        inset: 0;
        position: absolute;
    }
    .media-hero-card img {
        display: block;
        height: auto;
        object-fit: cover;
        width: 100%;
    }
    .media-pills {
        display: flex;
        flex-wrap: wrap;
        gap: .7rem;
    }
    .media-pills span {
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 999px;
        color: #fff;
        font-weight: 900;
        padding: .75rem 1rem;
    }
    .publication-thumb {
        aspect-ratio: 16 / 9;
        height: auto;
        object-fit: cover;
        width: 100%;
    }
    .publication-thumb-empty {
        align-items: center;
        background: linear-gradient(135deg, #eff6ff, #fff7ed);
        color: #2563eb;
        display: flex;
        font-size: 2rem;
        justify-content: center;
    }
    @media (max-width: 767.98px) {
        .media-page-hero .display-4 {
            font-size: clamp(2rem, 11vw, 3rem);
        }
    }
</style>
@endpush
@endsection
