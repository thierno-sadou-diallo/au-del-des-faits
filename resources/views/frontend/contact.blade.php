@extends('frontend.layout')

@section('content')
<section class="contact-hero page-hero p-4 p-lg-5 mb-5 african-decor">
    <div class="contact-orbit" aria-hidden="true">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="row align-items-end g-4">
        <div class="col-lg-8">
            <span class="badge mb-3">Contact</span>
            <h1 class="display-3 fw-bold mb-3"><span class="gradient-text">Echangeons sur votre projet</span></h1>
            <p class="lead mb-4">Un espace direct, elegant et humain pour transformer une idee, une demande media ou une collaboration en conversation concrete.</p>
            <div class="contact-hero-actions">
                <a href="#contact-form" class="btn btn-primary btn-lg">
                    <i class="fas fa-paper-plane me-2"></i>Demarrer l'echange
                </a>
                <a href="mailto:halimatouk484@gmail.com" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-envelope me-2"></i>Email direct
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="contact-signal">
                <span class="section-kicker">Priorites</span>
                <div class="signal-row">
                    <strong>48h</strong>
                    <span>delai moyen de reponse</span>
                </div>
                <div class="signal-row">
                    <strong>4</strong>
                    <span>formats de collaboration</span>
                </div>
                <div class="signal-row">
                    <strong>GMT</strong>
                    <span>Dakar, Afrique de l'Ouest</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mb-6 mt-6">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="contact-profile art-card h-100 p-4 p-lg-5">
                <span class="section-kicker">Informations</span>
                <h2 class="h3 fw-bold mt-3 mb-4"><span class="gradient-text">Restons en lien.</span></h2>

                <div class="contact-line" style="--line-delay: .02s;">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <strong>Email</strong>
                        <a href="mailto:halimatouk484@gmail.com">halimatouk484@gmail.com</a>
                    </div>
                </div>
                <div class="contact-line" style="--line-delay: .08s;">
                    <i class="fas fa-phone"></i>
                    <div>
                        <strong>Telephone</strong>
                        <a href="tel:+221123456789">+221 12 345 67 89</a>
                    </div>
                </div>
                <div class="contact-line" style="--line-delay: .14s;">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <strong>Localisation</strong>
                        <span>Dakar, Senegal</span>
                    </div>
                </div>
                <div class="contact-line" style="--line-delay: .2s;">
                    <i class="fas fa-clock"></i>
                    <div>
                        <strong>Disponibilite</strong>
                        <span>Lundi - Vendredi, 9h00 - 18h00 GMT</span>
                    </div>
                </div>

                <div class="social-links mt-4">
                    <a href="https://www.facebook.com/share/r/18SYrbWQMw/" class="fab fa-facebook-f" title="Facebook"></a>
                    <a href="https://www.instagram.com/au_dela_desfaits?igsh=MXB4YmZyYmFndmplMw==" class="fab fa-instagram" title="Instagram"></a>
                    <a href="https://www.linkedin.com/company/au-del%C3%A0-des-faits/" class="fab fa-linkedin-in" title="LinkedIn"></a>
                    <a href="#" class="fab fa-tiktok" title="TikTok"></a>
                </div>
                <div class="contact-photo mt-4">
                    <img src="{{ asset('images/ADF_me.jpg') }}" alt="Portrait" class="img-fluid rounded-4 shadow-sm">
                    <div class="portrait-caption">
                        <span>Au-dela des faits</span>
                        <strong>Analyse, media, dialogue public.</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="contact-form-card card h-100" id="contact-form">
                <div class="card-body p-4 p-lg-5">
                    <span class="section-kicker">Message</span>
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-4">
                        <h2 class="h3 fw-bold mt-3 mb-0">Envoyez une demande</h2>
                        <div class="message-meter" aria-hidden="true">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('contact.store') }}" class="row g-3">
                        @csrf
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold">Nom complet *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="organization" class="form-label fw-bold">Organisation</label>
                            <input type="text" class="form-control" id="organization" name="organization">
                        </div>
                        <div class="col-md-6">
                            <label for="subject" class="form-label fw-bold">Sujet *</label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="">Choisissez un sujet</option>
                                <option value="consulting">Demande de consulting</option>
                                <option value="conference">Conference / debat</option>
                                <option value="media">Demande media</option>
                                <option value="collaboration">Collaboration</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label fw-bold">Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                                <label class="form-check-label" for="newsletter">Je souhaite m'inscrire a la newsletter</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-paper-plane me-2"></i>Envoyer le message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-scope page-hero p-4 p-lg-5">
    <div class="row g-4 align-items-stretch">
        <div class="col-md-4">
            <div class="scope-item">
                <i class="fas fa-globe-africa"></i>
                <h2 class="h4 fw-bold"><span class="gradient-text">Zone d'intervention</span></h2>
                <p>Afrique de l'Ouest, France, Union europeenne et institutions internationales.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="scope-item">
                <i class="fas fa-hourglass-half"></i>
                <h2 class="h4 fw-bold"><span class="gradient-text">Delai de reponse</span></h2>
                <p>Les demandes sont generalement traitees sous 48 heures ouvrables.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="scope-item">
                <i class="fas fa-lightbulb"></i>
                <h2 class="h4 fw-bold"><span class="gradient-text">Sujets privilegies</span></h2>
                <p>Justice sociale, medias, droits humains, institutions et dynamiques africaines.</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .contact-hero {
        min-height: 440px;
        padding-top: clamp(2rem, 5vw, 5rem) !important;
    }
    .contact-hero .lead {
        max-width: 780px;
    }
    .contact-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: .85rem;
    }
    .contact-orbit {
        inset: 0;
        pointer-events: none;
        position: absolute;
    }
    .contact-orbit span {
        animation: contact-orbit 12s ease-in-out infinite alternate;
        border: 1px solid rgba(251, 191, 36, .34);
        border-radius: 42% 58% 64% 36%;
        position: absolute;
    }
    .contact-orbit span:nth-child(1) {
        height: 170px;
        right: 9%;
        top: 12%;
        width: 170px;
    }
    .contact-orbit span:nth-child(2) {
        animation-delay: -4s;
        bottom: -42px;
        height: 230px;
        right: 28%;
        width: 230px;
    }
    .contact-orbit span:nth-child(3) {
        animation-delay: -7s;
        height: 120px;
        left: 6%;
        top: 16%;
        width: 120px;
    }
    .contact-signal {
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(251, 191, 36, .28);
        border-radius: 20px;
        box-shadow: 0 22px 60px rgba(2, 6, 23, .22);
        padding: 1.25rem;
        backdrop-filter: blur(14px);
    }
    .signal-row {
        align-items: center;
        border-top: 1px solid rgba(255, 255, 255, .14);
        display: flex;
        gap: 1rem;
        padding: 1rem 0 0;
        margin-top: 1rem;
    }
    .signal-row strong {
        color: #fff;
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.55rem, 3vw, 2.45rem);
        line-height: 1;
        min-width: 72px;
    }
    .signal-row span {
        color: rgba(226, 232, 240, .86);
        font-size: .92rem;
        font-weight: 700;
        line-height: 1.35;
    }
    .contact-profile {
        transform-style: preserve-3d;
    }
    .contact-profile::before {
        background:
            linear-gradient(135deg, rgba(37,99,235,.12), transparent 40%),
            repeating-linear-gradient(90deg, rgba(2,6,23,.04) 0, rgba(2,6,23,.04) 1px, transparent 1px, transparent 16px);
        content: "";
        inset: 0;
        pointer-events: none;
        position: absolute;
    }
    .contact-line {
        align-items: flex-start;
        background: rgba(255, 255, 255, .68);
        border: 1px solid rgba(148, 163, 184, .18);
        border-radius: 18px;
        display: flex;
        gap: 1rem;
        margin-bottom: .85rem;
        padding: .95rem;
        position: relative;
        transition: transform .24s ease, border-color .24s ease, box-shadow .24s ease;
    }
    .contact-line:hover {
        border-color: rgba(245, 158, 11, .42);
        box-shadow: 0 16px 34px rgba(15, 23, 42, .08);
        transform: translateX(8px);
    }
    .contact-line i {
        align-items: center;
        background: linear-gradient(135deg, #020617, #2563eb);
        border-radius: 16px;
        box-shadow: 0 12px 24px rgba(37, 99, 235, .24);
        color: #fff;
        display: inline-flex;
        flex: 0 0 auto;
        height: 46px;
        justify-content: center;
        width: 46px;
    }
    .contact-line strong {
        display: block;
        color: #020617;
    }
    .contact-line a,
    .contact-line span {
        color: #475569;
        text-decoration: none;
    }
    .contact-photo img {
        width: 100%;
        display: block;
        object-fit: cover;
    }
    .contact-photo {
        position: relative;
    }
    .contact-photo::before {
        background: linear-gradient(135deg, rgba(56,189,248,.5), rgba(37,99,235,.12));
        border-radius: 28px;
        content: "";
        inset: -10px 22px 18px -10px;
        position: absolute;
        transform: rotate(-3deg);
        z-index: -1;
    }
    .portrait-caption {
        background: rgba(2, 6, 23, .82);
        border: 1px solid rgba(255, 255, 255, .14);
        border-radius: 16px;
        bottom: 1rem;
        left: 1rem;
        max-width: calc(100% - 2rem);
        padding: .85rem 1rem;
        position: absolute;
        backdrop-filter: blur(12px);
    }
    .portrait-caption span {
        color: #93c5fd;
        display: block;
        font-size: .72rem;
        font-weight: 900;
        letter-spacing: .14em;
        text-transform: uppercase;
    }
    .portrait-caption strong {
        color: #fff;
        display: block;
        font-size: .95rem;
        margin-top: .2rem;
    }
    .contact-form-card {
        background:
            linear-gradient(180deg, rgba(255,255,255,.98), rgba(248,250,252,.92)),
            radial-gradient(circle at 88% 10%, rgba(56,189,248,.22), transparent 14rem);
    }
    .contact-form-card.is-writing {
        border-color: rgba(245, 158, 11, .38) !important;
        box-shadow: 0 30px 80px rgba(15, 23, 42, .16), 0 0 0 1px rgba(245, 158, 11, .16) !important;
    }
    .contact-form-card label {
        color: #0f172a;
        font-size: .86rem;
    }
    .contact-form-card .form-control,
    .contact-form-card .form-select {
        background-color: rgba(255, 255, 255, .86);
        min-height: 52px;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }
    .contact-form-card textarea.form-control {
        min-height: 170px;
    }
    .contact-form-card .form-control:focus,
    .contact-form-card .form-select:focus {
        transform: translateY(-2px);
    }
    .message-meter {
        display: inline-grid;
        gap: .35rem;
        grid-template-columns: repeat(3, 34px);
    }
    .message-meter span {
        background: rgba(37, 99, 235, .14);
        border-radius: 999px;
        height: 7px;
        overflow: hidden;
        position: relative;
    }
    .message-meter span::after {
        animation: meter-fill 2.2s ease-in-out infinite;
        background: linear-gradient(90deg, #020617, #2563eb, #f59e0b);
        content: "";
        inset: 0;
        position: absolute;
        transform: translateX(-100%);
    }
    .message-meter span:nth-child(2)::after {
        animation-delay: .18s;
    }
    .message-meter span:nth-child(3)::after {
        animation-delay: .36s;
    }
    .contact-scope {
        margin-bottom: 2rem;
    }
    .scope-item {
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .14);
        border-radius: 20px;
        height: 100%;
        padding: 1.35rem;
        transition: transform .24s ease, background .24s ease;
    }
    .scope-item:hover {
        background: rgba(255, 255, 255, .13);
        border-color: rgba(251, 191, 36, .28);
        transform: translateY(-6px);
    }
    .scope-item i {
        align-items: center;
        background: rgba(255, 255, 255, .14);
        border-radius: 16px;
        color: #fbbf24;
        display: inline-flex;
        height: 48px;
        justify-content: center;
        margin-bottom: 1rem;
        width: 48px;
    }
    .scope-item p {
        margin-bottom: 0;
    }
    @media (max-width: 575.98px) {
        .contact-hero-actions .btn {
            width: 100%;
        }
        .signal-row {
            align-items: flex-start;
            flex-direction: column;
            gap: .35rem;
        }
        .message-meter {
            grid-template-columns: repeat(3, 1fr);
            width: 100%;
        }
    }
    @keyframes contact-orbit {
        from { transform: translate3d(0, 0, 0) rotate(0deg); opacity: .45; }
        to { transform: translate3d(18px, -22px, 0) rotate(18deg); opacity: .9; }
    }
    @keyframes meter-fill {
        0% { transform: translateX(-100%); }
        45%, 65% { transform: translateX(0); }
        100% { transform: translateX(100%); }
    }
</style>
@endpush

@push('scripts')
<script>
    document.querySelectorAll('.contact-form-card input, .contact-form-card textarea, .contact-form-card select').forEach((field) => {
        field.addEventListener('focus', () => field.closest('.contact-form-card').classList.add('is-writing'));
        field.addEventListener('blur', () => field.closest('.contact-form-card').classList.remove('is-writing'));
    });
</script>
@endpush
