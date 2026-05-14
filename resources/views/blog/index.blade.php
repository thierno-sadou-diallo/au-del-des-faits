@extends('frontend.layout')

@section('content')
<div class="row gy-4 mb-5">
    <div class="col-12">
        <div class="blog-hero rounded-4 bg-white shadow-sm p-5">
            <div class="row g-4 align-items-end">
                <div class="col-lg-8">
                    <span class="badge bg-primary mb-3">Blog professionnel</span>
                    <h1 class="display-5 fw-bold"><span class="gradient-text">Analyses sociologiques, temoignages et publications</span></h1>
                    <p class="lead text-secondary mt-3">Explorez des articles structures, visuellement soignes et penses pour une lecture immersive sur mobile comme sur desktop.</p>
                </div>
                <div class="col-lg-4">
                    <div class="blog-hero-stamp">
                        <i class="fas fa-feather-pointed"></i>
                        <span>Lecture critique</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row gy-4">
    <div class="col-lg-8">
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @forelse($posts as $post)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        @if($post->image)
                            <img src="{{ asset('storage/'.$post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                @if($post->category)
                                    <span class="badge bg-secondary">{{ $post->category->name }}</span>
                                @endif
                                <small class="text-muted ms-2">{{ $post->created_at->format('d/m/Y') }}</small>
                            </div>
                            <h2 class="h5 fw-bold"><a href="{{ route('blog.show', $post->slug) }}" class="text-dark text-decoration-none">{{ $post->title }}</a></h2>
                            <p class="text-muted mb-4">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $post->views }} vues</small>
                                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-sm btn-primary">Lire</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-secondary">Aucun article publié pour le moment.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">{{ $posts->onEachSide(1)->links('frontend.partials.pagination') }}</div>
    </div>

    <aside class="col-lg-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Articles récents</h5>
                <div class="list-group list-group-flush mt-3">
                    @forelse($recentPosts as $item)
                        <a href="{{ route('blog.show', $item->slug) }}" class="list-group-item list-group-item-action">{{ $item->title }}</a>
                    @empty
                        <p class="text-muted">Aucun article récent.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Pourquoi lire ce blog</h5>
                <p class="text-muted">Des articles clairs, une structure professionnelle et un design responsive pour une expérience de lecture de haut niveau.</p>
            </div>
        </div>
    </aside>
</div>
@endsection

@push('styles')
<style>
    .blog-hero-stamp {
        align-items: center;
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 22px;
        color: #fff;
        display: flex;
        gap: 1rem;
        padding: 1.25rem;
    }
    .blog-hero-stamp i {
        align-items: center;
        background: rgba(245, 158, 11, .22);
        border-radius: 16px;
        color: #fbbf24;
        display: inline-flex;
        height: 52px;
        justify-content: center;
        width: 52px;
    }
    .blog-hero-stamp span {
        font-family: 'Playfair Display', serif;
        font-size: 1.35rem;
        font-weight: 800;
    }
</style>
@endpush
