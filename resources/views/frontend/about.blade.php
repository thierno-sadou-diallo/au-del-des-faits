@extends('frontend.layout')

@section('content')
<section class="page-hero p-4 p-lg-5 mb-6 african-decor">
    <div class="row g-5 align-items-center">
        <div class="col-lg-7">
            <span class="badge mb-3">À propos</span>
            <h1 class="display-3 fw-bold mb-4"><span class="gradient-text">Au-delà des faits, une prise de position</span></h1>
            <p class="lead">Il y a des réalités que l'on voit tous les jours sans les questionner. Des injustices que l'on finit par accepter. Des normes qui deviennent invisibles. C'est de ce constat qu'est né Au-delà des faits.</p>
        </div>
        <div class="col-lg-5 text-center">
            <picture class="about-portrait">
                <source srcset="{{ asset('images/ADF_me.webp') }}" type="image/webp">
                <img src="{{ asset('images/ADF_me.jpg') }}" alt="Portrait de Halimatou Keita" class="portrait-img" loading="lazy" decoding="async">
                <span class="portrait-tag">Sociologie vivante</span>
                <div class="portrait-decor"></div>
            </picture>
        </div>
    </div>
</section>

<section class="mb-6 mt-6">
    <div class="row g-4 align-items-stretch">
        <div class="col-lg-7">
            <div class="art-card h-100 p-4 p-lg-5">
                <span class="section-kicker">Un regard entre analyse et engagement</span>
                <h2 class="h1 fw-bold mt-3 mb-4"><span class="gradient-text">Halimatou Keita</span></h2>
                <p>Je suis sociologue de la famille et de l'éducation, et étudiante en communication et relations publiques à l'UQAM au Canada.</p>
                <p>Mon parcours, entre le Canada et le Sénégal, m'a permis de développer un regard à la fois critique et nuancé sur les dynamiques sociales, les inégalités et les réalités humaines qui traversent nos sociétés.</p>
                <p>Mais comprendre ne m'a jamais suffi.</p>
                <div class="social-links mt-4">
                    <a href="https://www.facebook.com/share/r/18SYrbWQMw/" class="fab fa-facebook-f" title="Facebook" target="_blank" rel="noopener"></a>
                    <a href="https://www.instagram.com/au_dela_desfaits?igsh=MXB4YmZyYmFndmplMw==" class="fab fa-instagram" title="Instagram" target="_blank" rel="noopener"></a>
                    <a href="https://www.linkedin.com/company/au-del%C3%A0-des-faits/" class="fab fa-linkedin-in" title="LinkedIn" target="_blank" rel="noopener"></a>
                    <a href="https://youtube.com/@audeladesfaits24?si=rwrvJvKqaD1H1K9g" class="fab fa-youtube" title="YouTube" target="_blank" rel="noopener"></a>
                    <a href="https://www.tiktok.com/@audeladesfaits2024?_r=1&_t=ZS-96M1YTFoZyq" class="fab fa-tiktok" title="TikTok" target="_blank" rel="noopener"></a>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="row g-4 h-100">
                <div class="col-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="h4 fw-bold">Une nécessité de dire</h3>
                            <p>Très tôt, une question s'est imposée à moi :</p>
                            <ul class="clean-list">
                                <li>Pourquoi certaines injustices dérangent-elles si peu ?</li>
                                <li>Pourquoi ce qui devrait choquer devient banal ?</li>
                                <li>Pourquoi certaines voix restent invisibles, ignorées ou étouffées ?</li>
                            </ul>
                            <p>Éprise de justice et passionnée d'écriture, j'ai choisi de ne plus rester dans l'observation silencieuse. J'ai décidé d'écrire, d'analyser, de questionner.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="h4 fw-bold">Une voix entre plusieurs réalités</h3>
                            <p>Entre l'Afrique et l'Occident, mon regard se nourrit de contextes multiples. Cette position me permet d'explorer les tensions, les contradictions et les perceptions différentes qui façonnent nos sociétés.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mb-6 mt-6">
    <div class="row g-5 align-items-center">
        <div class="col-lg-4 text-center">
            <picture class="about-portrait">
                <source srcset="{{ asset('images/halimatou.webp') }}" type="image/webp">
                <img src="{{ asset('images/halimatou.jpg') }}" alt="Halimatou Keita, fondatrice de Au-delà des faits" class="portrait-img" loading="lazy" decoding="async">
                <span class="portrait-tag">Parcours</span>
                <div class="portrait-decor"></div>
            </picture>
        </div>
        <div class="col-lg-8">
            <div class="art-card p-4 p-lg-5">
                <span class="section-kicker">Ambition</span>
                <h2 class="h1 fw-bold mt-3 mb-4"><span class="gradient-text">Contribuer à une société plus juste</span></h2>
                <div class="presentation-text">
                    <p>À travers ce blog, je souhaite contribuer à une société plus consciente, plus juste et plus humaine. Une société où l'on ne se contente pas de voir, mais où l'on prend le temps de comprendre, de questionner et, peut-être, d'agir.</p>
                    <p>Ma cible est principalement la société sénégalaise, mais aussi la société africaine et occidentale de manière générale. Des thèmes liés au quotidien des individus seront abordés avec rigueur et sensibilité.</p>
                    <div class="welcome-section mt-4 p-4 bg-light rounded">
                        <h3 class="h4 fw-bold mb-3">Bienvenue</h3>
                        <p>Si vous êtes ici, ce n'est sans doute pas un hasard. Bienvenue dans un espace où l'on pense autrement.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-next p-4 p-lg-5 mb-6 mt-6">
    <div class="row g-4 align-items-center">
        <div class="col-lg-7">
            <span class="section-kicker text-sky">Après le constat</span>
            <h2>Faire circuler les idées, ouvrir la discussion.</h2>
            <p>
                Au-delà des faits n'est pas seulement un espace de publication. C'est un lieu
                pour relier les expériences, questionner les évidences et transformer l'analyse
                sociale en conversation utile.
            </p>
        </div>
        <div class="col-lg-5">
            <div class="about-actions">
                <a href="{{ route('blog.index') }}">
                    <i class="fas fa-newspaper"></i>
                    <span>
                        <strong>Lire les analyses</strong>
                        <small>Articles, regards critiques et textes de fond</small>
                    </span>
                </a>
                <a href="{{ route('medias') }}">
                    <i class="fas fa-photo-film"></i>
                    <span>
                        <strong>Voir les médias</strong>
                        <small>Vidéos, interventions et archives visuelles</small>
                    </span>
                </a>
                <a href="{{ route('contact') }}">
                    <i class="fas fa-paper-plane"></i>
                    <span>
                        <strong>Proposer un échange</strong>
                        <small>Collaboration, invitation ou demande de contact</small>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .about-portrait {
        aspect-ratio: 4 / 5;
        border: 1px solid rgba(255,255,255,.22);
        border-radius: 34px;
        box-shadow: 0 28px 80px rgba(2,6,23,.42);
        display: block;
        isolation: isolate;
        margin-inline: auto;
        max-width: 360px;
        overflow: hidden;
        position: relative;
    }
    .about-portrait::before {
        background:
            linear-gradient(120deg, rgba(255,255,255,.3), transparent 34%),
            radial-gradient(circle at 82% 18%, rgba(56,189,248,.32), transparent 9rem);
        content: "";
        inset: 0;
        position: absolute;
        z-index: 2;
    }
    .about-portrait::after {
        animation: portrait-line 7s ease-in-out infinite alternate;
        border: 1px solid rgba(255,255,255,.36);
        border-radius: 999px;
        content: "";
        height: 82%;
        left: 9%;
        position: absolute;
        top: 9%;
        width: 82%;
        z-index: 3;
    }
    .portrait-img {
        height: 100%;
        object-fit: cover;
        object-position: center;
        transform: scale(1.03);
        width: 100%;
    }
    .portrait-tag {
        background: rgba(255,255,255,.92);
        border-radius: 999px;
        bottom: 22px;
        color: #020617;
        font-weight: 900;
        left: 22px;
        padding: .75rem 1rem;
        position: absolute;
        z-index: 4;
    }
    .clean-list {
        display: grid;
        gap: .7rem;
        list-style: none;
        margin: 1rem 0;
        padding: 0;
    }
    .clean-list li {
        align-items: center;
        display: flex;
        font-weight: 700;
    }
    .clean-list li::before {
        background: #2563eb;
        border-radius: 999px;
        content: "";
        height: 8px;
        margin-right: .75rem;
        width: 8px;
    }
    .portrait-decor {
        background:
            repeating-linear-gradient(45deg, rgba(37, 99, 235, .12) 0, rgba(37, 99, 235, .12) 2px, transparent 2px, transparent 16px),
            repeating-linear-gradient(-45deg, rgba(56, 189, 248, .08) 0, rgba(56, 189, 248, .08) 2px, transparent 2px, transparent 16px);
        bottom: -80px;
        height: 160px;
        left: -40px;
        position: absolute;
        right: -40px;
        transform: rotate(-8deg);
        z-index: 1;
    }
    .welcome-section {
        background: rgba(56,189,248,.1);
        border-left: 4px solid #38bdf8;
        font-style: italic;
    }
    .welcome-section h3 {
        color: #38bdf8;
    }
    .about-next {
        background:
            linear-gradient(135deg, rgba(2, 6, 23, .97), rgba(15, 23, 42, .93) 52%, rgba(37, 99, 235, .82)),
            radial-gradient(circle at 8% 20%, rgba(245, 158, 11, .26), transparent 16rem),
            radial-gradient(circle at 96% 86%, rgba(56, 189, 248, .28), transparent 18rem);
        border: 1px solid rgba(255, 255, 255, .14);
        border-radius: 26px;
        box-shadow: 0 28px 80px rgba(15, 23, 42, .18);
        color: #fff;
        overflow: hidden;
        position: relative;
    }
    .about-next::before {
        background:
            linear-gradient(rgba(255,255,255,.08) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px);
        background-size: 46px 46px;
        content: "";
        inset: 0;
        opacity: .24;
        position: absolute;
    }
    .about-next > .row {
        position: relative;
        z-index: 1;
    }
    .about-next h2 {
        color: #fff;
        font-size: clamp(2.25rem, 5vw, 4.6rem);
        line-height: .98;
        margin: .8rem 0 1rem;
        max-width: 760px;
    }
    .about-next p {
        color: rgba(241, 245, 249, .88) !important;
        font-size: 1.08rem;
        max-width: 700px;
    }
    .about-actions {
        display: grid;
        gap: .85rem;
    }
    .about-actions a {
        align-items: center;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 18px;
        color: #fff;
        display: flex;
        gap: 1rem;
        padding: 1rem;
        text-decoration: none;
        transition: transform .2s ease, background .2s ease, border-color .2s ease;
    }
    .about-actions a:hover {
        background: rgba(255, 255, 255, .16);
        border-color: rgba(125, 211, 252, .42);
        color: #fff;
        transform: translateX(6px);
    }
    .about-actions i {
        align-items: center;
        background: linear-gradient(135deg, #f59e0b, #2563eb);
        border-radius: 14px;
        display: inline-flex;
        flex: 0 0 auto;
        height: 48px;
        justify-content: center;
        width: 48px;
    }
    .about-actions strong,
    .about-actions small {
        display: block;
    }
    .about-actions strong {
        font-size: 1rem;
        line-height: 1.2;
    }
    .about-actions small {
        color: rgba(226, 232, 240, .78);
        font-size: .86rem;
        margin-top: .15rem;
    }
    @keyframes portrait-line {
        from { transform: rotate(-8deg) scale(.96); }
        to { transform: rotate(12deg) scale(1.05); }
    }
</style>
@endpush
