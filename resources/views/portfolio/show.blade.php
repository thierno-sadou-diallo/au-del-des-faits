@extends('frontend.layout')

@section('content')
<div class="portfolio-detail row gy-4">
    <div class="col-lg-8">
        <div class="portfolio-detail-card card shadow-sm border-0">
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                    @if($project->category)
                        <span class="badge bg-secondary">{{ $project->category->name }}</span>
                    @endif
                    <small class="text-muted">{{ $project->created_at?->format('d/m/Y') }}</small>
                    <small class="text-muted">{{ $project->likes ?? 0 }} likes</small>
                </div>
                <h1 class="display-5 fw-bold"><span class="gradient-text">{{ $project->title }}</span></h1>
                <p class="text-secondary">{{ $project->description }}</p>

                @if(!empty($project->images))
                    <div class="row g-3 mt-4">
                        @foreach($project->images as $image)
                            <div class="col-md-6">
                                <img src="{{ asset('storage/'.$image) }}" class="img-fluid rounded-4" alt="{{ $project->title }}">
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($project->technologies)
                    <div class="mt-4">
                        <h6 class="fw-semibold">Mots-clés</h6>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @foreach($project->technologies as $tech)
                                <span class="badge bg-light text-dark">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-4 d-flex flex-wrap gap-2">
                    @if($project->link)
                        <a href="{{ $project->link }}" target="_blank" class="btn btn-primary">Voir le projet</a>
                    @endif
                    @if($project->video_url)
                        <a href="{{ $project->video_url }}" target="_blank" class="btn btn-outline-primary">Voir la vidéo</a>
                    @endif
                    <form action="{{ route('portfolio.like', $project) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-primary like-btn" type="submit" id="like-btn">
                            <i class="fas fa-heart me-2"></i>J'aime ({{ $project->likes ?? 0 }})
                        </button>
                    </form>
                </div>

                <section class="mt-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h2 class="h5 fw-bold">Laisser un commentaire</h2>
                            <p class="text-muted">Les commentaires sont publiés après modération.</p>
                            <form class="row g-3 mt-3" method="POST" action="{{ route('portfolio.comments.store', $project) }}">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label">Nom</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control" name="message" rows="5" required></textarea>
                                </div>
                                <div class="col-md-9" id="captcha-wrapper">{!! captcha_img() !!}</div>
                                <div class="col-md-3 d-grid">
                                    <button type="button" class="btn btn-outline-secondary" onclick="refreshCaptcha()">Rafraîchir</button>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="captcha" placeholder="Captcha" required>
                                </div>
                                <div class="col-12 d-grid">
                                    <button class="btn btn-primary" type="submit">Envoyer le commentaire</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>

                <section class="mt-4">
                    <div class="card comments-panel shadow-sm border-0">
                        <div class="card-body p-4">
                            <span class="section-kicker">Discussion</span>
                            <h2 class="h4 fw-bold mb-1"><span class="gradient-text">Commentaires</span></h2>
                            <p class="text-muted mb-4">Les échanges approuvés apparaissent ici, avec les réponses de l'équipe éditoriale.</p>
                            @forelse($project->comments()->where('is_approved', true)->whereNull('parent_id')->get() as $comment)
                                <div class="comment-thread">
                                    <div class="comment-bubble">
                                        <div class="comment-meta">
                                            <span class="comment-avatar">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($comment->name, 0, 1)) }}</span>
                                            <div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <p class="fw-bold mb-0">{{ $comment->name }}</p>
                                                    @if($comment->user && $comment->user->badge_level !== 'none')
                                                        <span class="user-badge {{ $comment->user->badge_level }}">
                                                            {{ $comment->user->badge_level === 'curator' ? '⭐ Curateur' : ($comment->user->badge_level === 'super-fan' ? '❤️ Super Fan' : '👤 Contributeur') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                        </div>
                                        <p class="text-muted mb-0 mt-3">{!! nl2br(e($comment->message)) !!}</p>
                                    </div>

                                    <div class="reply-list">
                                        @foreach($comment->replies()->where('is_approved', true)->get() as $reply)
                                            <div class="reply-bubble">
                                                <div class="comment-meta">
                                                    <span class="comment-avatar admin-avatar"><i class="fas fa-feather-pointed"></i></span>
                                                    <div>
                                                        <p class="fw-bold mb-0">{{ $reply->name }}</p>
                                                        <small class="text-muted">Réponse de l'équipe - {{ $reply->created_at->format('d/m/Y H:i') }}</small>
                                                    </div>
                                                </div>
                                                <p class="text-muted mb-0 mt-3">{!! nl2br(e($reply->message)) !!}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">Aucun commentaire approuvé.</p>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <aside class="col-lg-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">À propos de ce projet</h5>
                <p class="text-muted">Ce contenu est conçu pour valoriser vos médias, images et interventions avec une présentation professionnelle et dynamique.</p>
            </div>
        </div>

        @if(isset($similarProjects) && $similarProjects->isNotEmpty())
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Projets similaires</h5>
                    <div class="list-group list-group-flush mt-3">
                        @foreach($similarProjects as $item)
                            <a href="{{ route('portfolio.show', $item->slug) }}" class="list-group-item list-group-item-action">{{ $item->title }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </aside>
</div>
@endsection

@push('styles')
<style>
    .portfolio-detail-card {
        border-radius: 26px;
    }
    .portfolio-detail-card .row img {
        box-shadow: 0 18px 44px rgba(15,23,42,.14);
        transition: transform .28s ease, box-shadow .28s ease;
    }
    .portfolio-detail-card .row img:hover {
        box-shadow: 0 26px 64px rgba(15,23,42,.2);
        transform: translateY(-5px) scale(1.015);
    }
    .portfolio-detail .badge.bg-light {
        background: rgba(245,158,11,.14) !important;
        border: 1px solid rgba(245,158,11,.22);
        color: #78350f !important;
    }

    /* Styles pour les commentaires */
    .comments-panel {
        border-radius: 20px !important;
    }

    .comment-thread {
        padding: 1.5rem 0;
        border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .comment-bubble {
        background: rgba(255,255,255,.04);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
    }

    .comment-meta {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .comment-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #38bdf8);
        color: white;
        font-weight: bold;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .comment-avatar.admin-avatar {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .reply-list {
        margin-left: 2rem;
        border-left: 2px solid rgba(56,189,248,.3);
        padding-left: 1.5rem;
        margin-top: 1rem;
    }

    .reply-bubble {
        background: rgba(56,189,248,.08);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 0.75rem;
    }

    /* Animation des cœurs qui explosent */
    .like-btn {
        position: relative;
        overflow: hidden;
    }

    .like-btn.active {
        background: linear-gradient(135deg, #ec4899, #f43f5e) !important;
        border-color: #f43f5e !important;
        color: white !important;
    }

    .heart-explode {
        position: fixed;
        pointer-events: none;
        font-size: 2rem;
        animation: heartExplode 0.8s ease-out forwards;
        z-index: 1000;
    }

    @keyframes heartExplode {
        0% {
            opacity: 1;
            transform: translate(0, 0) scale(1);
        }
        50% {
            opacity: 1;
        }
        100% {
            opacity: 0;
            transform: translate(var(--tx), var(--ty)) scale(0);
        }
    }

    /* Badge pour utilisateurs actifs */
    .user-badge {
        display: inline-block;
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-left: 0.5rem;
    }

    .user-badge.super-fan {
        background: linear-gradient(135deg, #ec4899, #f43f5e);
    }

    .user-badge.curator {
        background: linear-gradient(135deg, #8b5cf6, #a855f7);
    }
</style>
@endpush

@push('scripts')
<script>
    function refreshCaptcha() {
        $.ajax({
            url: '{{ route("captcha.refresh") }}',
            type: 'GET',
            success: function(response) {
                $('#captcha-wrapper').html(response.captcha);
            }
        });
    }

    // Animation des cœurs qui explosent
    document.getElementById('like-btn')?.addEventListener('click', function(e) {
        if (e.type === 'click' && !e.target.closest('form').onsubmit) {
            createHeartExplosion(e);
        }
    });

    function createHeartExplosion(event) {
        const button = event.currentTarget;
        const rect = button.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;

        const heartCount = 8;
        for (let i = 0; i < heartCount; i++) {
            const angle = (i / heartCount) * Math.PI * 2;
            const distance = 80;
            const tx = Math.cos(angle) * distance;
            const ty = Math.sin(angle) * distance - 50;

            const heart = document.createElement('div');
            heart.className = 'heart-explode';
            heart.textContent = '❤️';
            heart.style.left = centerX + 'px';
            heart.style.top = centerY + 'px';
            heart.style.setProperty('--tx', tx + 'px');
            heart.style.setProperty('--ty', ty + 'px');

            document.body.appendChild(heart);

            setTimeout(() => heart.remove(), 800);
        }
    }
</script>
@endpush
