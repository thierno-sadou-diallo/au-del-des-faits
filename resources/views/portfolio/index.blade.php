@extends('frontend.layout')

@section('content')
<div class="row gy-4 mb-5">
    <div class="col-12">
        <div class="portfolio-hero rounded-4 bg-white shadow-sm p-4 p-lg-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-primary mb-3">Portfolio</span>
                    <h1 class="display-5 fw-bold"><span class="gradient-text">Realisations et medias visuels</span></h1>
                    <p class="lead text-secondary mt-3">Decouvrez les projets et les medias publies avec une approche sociologique forte et une presentation engagee.</p>
                </div>
                <div class="col-lg-4">
                    <div class="portfolio-lens">
                        <span></span>
                        <i class="fas fa-camera-retro"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
            @forelse($projects as $project)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        @if(!empty($project->images[0]))
                            <img src="{{ asset('storage/'.$project->images[0]) }}" class="card-img-top publication-thumb" alt="{{ $project->title }}" loading="lazy" decoding="async">
                        @else
                            <div class="publication-thumb publication-thumb-empty">
                                <i class="fas fa-camera-retro"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                @if($project->category)
                                    <span class="badge bg-secondary">{{ $project->category->name }}</span>
                                @endif
                            </div>
                            <h2 class="h5 fw-bold"><a href="{{ route('portfolio.show', $project->slug) }}" class="text-dark text-decoration-none">{{ $project->title }}</a></h2>
                            <p class="text-muted">{{ \Illuminate\Support\Str::limit($project->description, 110) }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $project->likes ?? 0 }} likes</small>
                                <a href="{{ route('portfolio.show', $project->slug) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-secondary">Aucun projet trouvé.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">{{ $projects->onEachSide(1)->links('frontend.partials.pagination') }}</div>
    </div>

    <aside class="col-lg-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Pourquoi ce portfolio</h5>
                <p class="text-muted">Un portfolio professionnel structure vos réalisations et valorise vos médias auprès de partenaires et clients.</p>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Responsive design</h5>
                <p class="text-muted">Affichage optimisé pour smartphone, tablette et grand écran pour un rendu premium.</p>
            </div>
        </div>
    </aside>
</div>
@endsection

@push('styles')
<style>
    .portfolio-lens {
        align-items: center;
        aspect-ratio: 1 / 1;
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 28px;
        display: flex;
        justify-content: center;
        margin-left: auto;
        max-width: 220px;
        overflow: hidden;
        position: relative;
    }
    .portfolio-lens span {
        animation: lens-spin 16s linear infinite;
        border: 1px dashed rgba(251, 191, 36, .55);
        border-radius: 50%;
        height: 74%;
        position: absolute;
        width: 74%;
    }
    .portfolio-lens i {
        color: #fbbf24;
        font-size: 3rem;
        position: relative;
        z-index: 1;
    }
    @keyframes lens-spin {
        to { transform: rotate(360deg); }
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
        .portfolio-hero .display-5 {
            font-size: clamp(2rem, 11vw, 3rem);
        }
    }
</style>
@endpush
