@extends('frontend.layout')

@section('content')
@php
    $shareUrl = request()->fullUrl();
    $shareTitle = $post->title;
    $shareText = \Illuminate\Support\Str::limit($post->excerpt, 140);
@endphp

<div class="article-layout row gy-4">
    <div class="col-lg-8">
        <article class="article-reader card shadow-sm border-0">
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                    @if($post->category)
                        <span class="badge bg-secondary">{{ $post->category->name }}</span>
                    @endif
                    <small class="text-muted">{{ $post->created_at->format('d/m/Y') }}</small>
                    <small class="text-muted">{{ $post->views }} vues</small>
                    <small class="text-muted">{{ $post->likes ?? 0 }} likes</small>
                </div>

                <h1 class="display-5 fw-bold"><span class="gradient-text">{{ $post->title }}</span></h1>
                <p class="lead text-secondary">{{ $post->excerpt }}</p>

                <div class="voice-reader mt-4" id="voice-reader">
                    <div>
                        <span class="section-kicker">Lecture vocale</span>
                        <p class="mb-0 text-muted">Ecoutez cet article en audio directement depuis la page.</p>
                    </div>
                    <div class="voice-actions">
                        <button type="button" class="btn btn-primary" id="voice-play">
                            <i class="fas fa-volume-high me-2"></i>Ecouter
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="voice-pause">
                            <i class="fas fa-pause me-2"></i>Pause
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="voice-stop">
                            <i class="fas fa-stop me-2"></i>Arreter
                        </button>
                    </div>
                </div>

                <div class="translation-panel mt-4" id="translation-panel">
                    <div class="translation-head">
                        <div>
                            <span class="section-kicker">Traduction</span>
                            <h2 class="h4 fw-bold mb-1"><span class="gradient-text">Lire cet article dans une autre langue</span></h2>
                            <p class="mb-0 text-muted">Choisissez une langue pour afficher une version traduite.</p>
                        </div>
                        <div class="translation-actions">
                            <button type="button" class="translation-button" data-language="en">Anglais</button>
                            <button type="button" class="translation-button" data-language="wo">Wolof</button>
                            <button type="button" class="translation-button" data-language="es">Espagnol</button>
                        </div>
                    </div>
                    <div class="translation-output" id="translation-output" hidden></div>
                </div>

                @if($post->image_url)
                    <img src="{{ $post->image_url }}" class="article-main-image img-fluid rounded-4 my-4" alt="{{ $post->title }}">
                @else
                    <img src="{{ asset('images/ADF.jpg') }}" class="article-main-image img-fluid rounded-4 my-4" alt="{{ $post->title }}">
                @endif

                <div class="content article-content text-secondary">{!! $post->content_html !!}</div>

                <div class="mt-4 d-flex flex-wrap gap-2 align-items-center">
                    <form action="{{ route('blog.like', $post) }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-primary" type="submit">J'aime</button>
                    </form>
                </div>

                <section class="share-panel mt-4">
                    <div class="d-flex flex-column flex-lg-row gap-3 align-items-lg-center justify-content-between">
                        <div>
                            <span class="section-kicker">Partager</span>
                            <h2 class="h4 fw-bold mb-1"><span class="gradient-text">Diffusez cet article</span></h2>
                            <p class="mb-0 text-muted">Choisissez votre reseau prefere ou copiez le lien.</p>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="nativeShareArticle()">
                            <i class="fas fa-share-nodes me-2"></i>Partager via mon appareil
                        </button>
                    </div>

                    <div class="share-grid mt-4">
                        <a class="share-button" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener">
                            <i class="fab fa-facebook-f"></i><span>Facebook</span>
                        </a>
                        <a class="share-button" href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTitle) }}" target="_blank" rel="noopener">
                            <i class="fab fa-x-twitter"></i><span>X</span>
                        </a>
                        <a class="share-button" href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($shareUrl) }}" target="_blank" rel="noopener">
                            <i class="fab fa-linkedin-in"></i><span>LinkedIn</span>
                        </a>
                        <a class="share-button" href="https://api.whatsapp.com/send?text={{ urlencode($shareTitle.' '.$shareUrl) }}" target="_blank" rel="noopener">
                            <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
                        </a>
                        <a class="share-button" href="https://t.me/share/url?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTitle) }}" target="_blank" rel="noopener">
                            <i class="fab fa-telegram-plane"></i><span>Telegram</span>
                        </a>
                        <a class="share-button" href="https://www.reddit.com/submit?url={{ urlencode($shareUrl) }}&title={{ urlencode($shareTitle) }}" target="_blank" rel="noopener">
                            <i class="fab fa-reddit-alien"></i><span>Reddit</span>
                        </a>
                        <a class="share-button" href="mailto:?subject={{ rawurlencode($shareTitle) }}&body={{ rawurlencode($shareText."\n\n".$shareUrl) }}">
                            <i class="fas fa-envelope"></i><span>Email</span>
                        </a>
                        <button type="button" class="share-button" id="copy-share-link" onclick="copyArticleLink()">
                            <i class="fas fa-link"></i><span>Copier le lien</span>
                        </button>
                    </div>
                </section>
            </div>
        </article>

        <section class="mt-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold">Laisser un commentaire</h2>
                    <p class="text-muted">Les commentaires sont publies apres moderation.</p>
                    <form class="row g-3 mt-3" method="POST" action="{{ route('blog.comments.store', $post) }}">
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
                            <button type="button" class="btn btn-outline-secondary" onclick="refreshCaptcha()">Rafraichir</button>
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
                    <h2 class="h4 fw-bold mb-1"><span class="gradient-text">Commentaires et réponses</span></h2>
                    <p class="text-muted mb-4">Les échanges approuvés apparaissent ici, avec les réponses de l'équipe éditoriale.</p>
                    @forelse($post->comments as $comment)
                        <div class="comment-thread">
                            <div class="comment-bubble">
                                <div class="comment-meta">
                                    <span class="comment-avatar">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($comment->name, 0, 1)) }}</span>
                                    <div>
                                        <p class="fw-bold mb-0">{{ $comment->name }}</p>
                                        <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                </div>
                                <p class="text-muted mb-0 mt-3">{!! nl2br(e($comment->message)) !!}</p>
                            </div>

                            <div class="reply-list">
                                @foreach($comment->replies as $reply)
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

    <aside class="col-lg-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Articles similaires</h5>
                <div class="list-group list-group-flush mt-3">
                    @forelse($similarPosts as $item)
                        <a href="{{ route('blog.show', $item->slug) }}" class="list-group-item list-group-item-action">{{ $item->title }}</a>
                    @empty
                        <p class="text-muted">Aucun article similaire.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Articles recents</h5>
                <ul class="list-unstyled mt-3 mb-0">
                    @forelse($recentPosts as $item)
                        <li class="mb-3"><a href="{{ route('blog.show', $item->slug) }}" class="text-decoration-none">{{ $item->title }}</a></li>
                    @empty
                        <p class="text-muted">Aucun article recent.</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </aside>
</div>

<script>
    const articleShareData = {
        title: @json($shareTitle),
        text: @json($shareText),
        url: @json($shareUrl),
    };
    const articleVoiceText = @json($post->title . '. ' . $post->excerpt . ' ' . strip_tags($post->content));
    let articleUtterance = null;

    function getArticleUtterance() {
        const utterance = new SpeechSynthesisUtterance(articleVoiceText.replace(/\s+/g, ' ').trim());
        utterance.lang = 'fr-FR';
        utterance.rate = 0.95;
        utterance.pitch = 1;
        return utterance;
    }

    function updateVoiceState(state) {
        const reader = document.getElementById('voice-reader');
        if (reader) {
            reader.dataset.state = state;
        }
    }

    function playArticleVoice() {
        if (!('speechSynthesis' in window)) {
            alert('La lecture vocale n est pas disponible sur ce navigateur.');
            return;
        }

        if (window.speechSynthesis.paused) {
            window.speechSynthesis.resume();
            updateVoiceState('playing');
            return;
        }

        window.speechSynthesis.cancel();
        articleUtterance = getArticleUtterance();
        articleUtterance.onend = () => updateVoiceState('idle');
        articleUtterance.onerror = () => updateVoiceState('idle');
        window.speechSynthesis.speak(articleUtterance);
        updateVoiceState('playing');
    }

    function pauseArticleVoice() {
        if ('speechSynthesis' in window && window.speechSynthesis.speaking) {
            window.speechSynthesis.pause();
            updateVoiceState('paused');
        }
    }

    function stopArticleVoice() {
        if ('speechSynthesis' in window) {
            window.speechSynthesis.cancel();
            updateVoiceState('idle');
        }
    }

    document.getElementById('voice-play')?.addEventListener('click', playArticleVoice);
    document.getElementById('voice-pause')?.addEventListener('click', pauseArticleVoice);
    document.getElementById('voice-stop')?.addEventListener('click', stopArticleVoice);
    window.addEventListener('beforeunload', stopArticleVoice);

    document.querySelectorAll('.translation-button').forEach((button) => {
        button.addEventListener('click', async () => {
            const output = document.getElementById('translation-output');
            const language = button.dataset.language;
            document.querySelectorAll('.translation-button').forEach((item) => item.classList.remove('is-active'));
            button.classList.add('is-active');
            output.hidden = false;
            output.textContent = 'Traduction en cours...';

            try {
                const response = await fetch(`{{ route('blog.translate', $post->slug) }}?language=${language}`);
                const data = await response.json();
                output.textContent = data.translation || 'Traduction indisponible.';
            } catch (error) {
                output.textContent = 'Impossible de charger la traduction pour le moment.';
            }
        });
    });

    async function refreshCaptcha() {
        const response = await fetch('{{ route('captcha.refresh') }}');
        const data = await response.json();
        document.getElementById('captcha-wrapper').innerHTML = data.captcha;
    }

    async function nativeShareArticle() {
        if (navigator.share) {
            await navigator.share(articleShareData);
            return;
        }

        await copyArticleLink();
    }

    async function copyArticleLink() {
        const button = document.getElementById('copy-share-link');
        try {
            await navigator.clipboard.writeText(articleShareData.url);
            if (button) {
                const label = button.querySelector('span');
                const previousText = label.textContent;
                label.textContent = 'Lien copie';
                window.setTimeout(() => label.textContent = previousText, 1800);
            }
        } catch (error) {
            window.prompt('Copiez ce lien', articleShareData.url);
        }
    }
</script>

@push('styles')
<style>
    .share-panel {
        background:
            linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,255,255,.76)),
            radial-gradient(circle at 88% 16%, rgba(56,189,248,.2), transparent 14rem);
        border: 1px solid rgba(148, 163, 184, .24);
        border-radius: 22px;
        padding: 1.5rem;
    }
    .share-grid {
        display: grid;
        gap: .75rem;
        grid-template-columns: repeat(auto-fit, minmax(135px, 1fr));
    }
    .share-button {
        align-items: center;
        background: #fff;
        border: 1px solid rgba(148, 163, 184, .28);
        border-radius: 16px;
        color: #020617;
        display: inline-flex;
        font-weight: 900;
        gap: .7rem;
        justify-content: center;
        min-height: 52px;
        padding: .8rem 1rem;
        text-decoration: none;
        transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease, background .2s ease, color .2s ease;
        width: 100%;
    }
    button.share-button {
        cursor: pointer;
    }
    .share-button:hover {
        background: linear-gradient(135deg, #020617, #2563eb);
        border-color: transparent;
        box-shadow: 0 16px 34px rgba(15,23,42,.16);
        color: #fff;
        transform: translateY(-3px);
    }
    .share-button i {
        font-size: 1.1rem;
    }
    .article-reader {
        border-radius: 26px;
    }
    .article-reader > .card-body {
        background:
            linear-gradient(180deg, rgba(255,255,255,.98), rgba(255,255,255,.9)),
            repeating-linear-gradient(90deg, rgba(37,99,235,.035) 0, rgba(37,99,235,.035) 1px, transparent 1px, transparent 26px);
    }
    .article-reader .content {
        color: #334155;
        font-size: 1.08rem;
    }
    .article-main-image {
        max-height: 520px;
        object-fit: cover;
        width: 100%;
    }
    .article-content > * + * {
        margin-top: 1rem;
    }
    .article-content h1,
    .article-content h2,
    .article-content h3,
    .article-content h4 {
        color: #0f172a;
        font-family: 'Playfair Display', serif;
        font-weight: 800;
        line-height: 1.2;
        margin-top: 1.8rem;
    }
    .article-content p,
    .article-content li {
        line-height: 1.9;
    }
    .article-content img {
        border-radius: 18px;
        height: auto;
        max-width: 100%;
    }
    .article-reader .content p:first-of-type::first-letter {
        color: #2563eb;
        float: left;
        font-family: 'Playfair Display', serif;
        font-size: 4.2rem;
        font-weight: 800;
        line-height: .85;
        padding-right: .45rem;
    }
    .voice-reader {
        align-items: center;
        background:
            linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,247,237,.82)),
            radial-gradient(circle at 92% 12%, rgba(245,158,11,.18), transparent 10rem);
        border: 1px solid rgba(245, 158, 11, .24);
        border-radius: 22px;
        display: flex;
        gap: 1rem;
        justify-content: space-between;
        padding: 1rem;
    }
    .voice-reader[data-state="playing"] {
        box-shadow: 0 18px 44px rgba(245, 158, 11, .16);
    }
    .voice-reader[data-state="playing"] .section-kicker::after {
        color: #15803d;
        content: " en cours";
    }
    .voice-reader[data-state="paused"] .section-kicker::after {
        color: #b45309;
        content: " en pause";
    }
    .voice-actions {
        display: flex;
        flex-wrap: wrap;
        gap: .55rem;
        justify-content: flex-end;
    }
    .translation-panel {
        background:
            linear-gradient(180deg, rgba(255,255,255,.94), rgba(255,247,237,.84)),
            radial-gradient(circle at 8% 100%, rgba(21,128,61,.12), transparent 11rem);
        border: 1px solid rgba(21, 128, 61, .18);
        border-radius: 22px;
        padding: 1rem;
    }
    .translation-head {
        align-items: center;
        display: flex;
        gap: 1rem;
        justify-content: space-between;
    }
    .translation-actions {
        display: flex;
        flex-wrap: wrap;
        gap: .55rem;
        justify-content: flex-end;
    }
    .translation-button {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, .26);
        border-radius: 999px;
        color: #0f172a;
        font-weight: 900;
        padding: .7rem 1rem;
        transition: transform .2s ease, background .2s ease, color .2s ease, border-color .2s ease;
    }
    .translation-button:hover,
    .translation-button.is-active {
        background: linear-gradient(135deg, #7c2d12, #2563eb);
        border-color: transparent;
        color: #fff;
        transform: translateY(-2px);
    }
    .translation-output {
        background: rgba(255,255,255,.78);
        border: 1px solid rgba(148, 163, 184, .2);
        border-radius: 18px;
        color: #334155;
        line-height: 1.85;
        margin-top: 1rem;
        padding: 1rem;
        white-space: pre-wrap;
    }
    .comments-panel {
        border-radius: 24px;
        overflow: hidden;
    }
    .comments-panel > .card-body {
        background:
            linear-gradient(180deg, rgba(255,255,255,.98), rgba(239,246,255,.86)),
            radial-gradient(circle at 92% 6%, rgba(56,189,248,.16), transparent 13rem);
    }
    .comment-thread {
        margin-top: 1rem;
        position: relative;
    }
    .comment-thread + .comment-thread {
        border-top: 1px solid rgba(148, 163, 184, .2);
        padding-top: 1.25rem;
    }
    .comment-bubble,
    .reply-bubble {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, .24);
        border-radius: 20px;
        box-shadow: 0 12px 28px rgba(15, 23, 42, .06);
        padding: 1rem;
    }
    .comment-meta {
        align-items: center;
        display: flex;
        gap: .75rem;
    }
    .comment-avatar {
        align-items: center;
        background: linear-gradient(135deg, #020617, #2563eb);
        border-radius: 14px;
        color: #fff;
        display: inline-flex;
        flex: 0 0 auto;
        font-weight: 900;
        height: 44px;
        justify-content: center;
        width: 44px;
    }
    .admin-avatar {
        background: linear-gradient(135deg, #f59e0b, #2563eb);
    }
    .reply-list {
        border-left: 3px solid rgba(37, 99, 235, .18);
        display: grid;
        gap: .8rem;
        margin-left: 1.35rem;
        margin-top: .9rem;
        padding-left: 1rem;
    }
    .reply-bubble {
        background:
            linear-gradient(180deg, rgba(255,255,255,.96), rgba(239,246,255,.9)),
            radial-gradient(circle at 100% 0, rgba(245,158,11,.12), transparent 9rem);
        border-color: rgba(37, 99, 235, .18);
    }
    @media (max-width: 767.98px) {
        .voice-reader {
            align-items: stretch;
            flex-direction: column;
        }
        .voice-actions .btn {
            flex: 1 1 auto;
        }
        .translation-head {
            align-items: stretch;
            flex-direction: column;
        }
        .translation-actions {
            justify-content: flex-start;
        }
        .reply-list {
            margin-left: .5rem;
            padding-left: .75rem;
        }
    }
</style>
@endpush
@endsection
