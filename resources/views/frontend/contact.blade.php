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
            <h1 class="display-3 fw-bold mb-3"><span class="gradient-text">Entrer en relation simplement</span></h1>
            <p class="lead mb-4">Une page claire pour choisir le bon canal, préparer votre demande et orienter rapidement les collaborations, médias, conférences ou accompagnements.</p>
            <div class="contact-hero-actions">
                <a href="{{ route('appointment.fr') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-calendar-check me-2"></i>Prendre rendez-vous
                </a>
                <a href="mailto:halimatouk484@gmail.com?subject=Demande%20de%20contact%20-%20Au-del%C3%A0%20des%20faits" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-envelope me-2"></i>Email direct
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="contact-signal">
                <span class="section-kicker">Repères</span>
                <div class="signal-row">
                    <strong>48h</strong>
                    <span>délai moyen de réponse</span>
                </div>
                <div class="signal-row">
                    <strong>4</strong>
                    <span>types de demandes prioritaires</span>
                </div>
                <div class="signal-row">
                    <strong>GMT</strong>
                    <span>Dakar, Afrique de l'Ouest</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mb-5">
    <div class="row g-4 align-items-stretch">
        <div class="col-lg-5">
            <div class="contact-profile art-card h-100 p-4 p-lg-5">
                <span class="section-kicker">Coordonnées</span>
                <h2 class="h3 fw-bold mt-3 mb-4"><span class="gradient-text">Les canaux directs</span></h2>

                <a class="contact-line" href="mailto:halimatouk484@gmail.com">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <strong>Email professionnel</strong>
                        <span>halimatouk484@gmail.com</span>
                    </div>
                </a>
                <a class="contact-line" href="{{ route('appointment.fr') }}">
                    <i class="fas fa-calendar-check"></i>
                    <div>
                        <strong>Rendez-vous structuré</strong>
                        <span>Pour les demandes de conseil, entretien, suivi ou collaboration.</span>
                    </div>
                </a>
                <div class="contact-line">
                    <i class="fas fa-location-dot"></i>
                    <div>
                        <strong>Localisation</strong>
                        <span>Dakar, Sénégal · échanges possibles à distance</span>
                    </div>
                </div>
                <div class="contact-line">
                    <i class="fas fa-clock"></i>
                    <div>
                        <strong>Disponibilité</strong>
                        <span>Lundi - vendredi, 9h00 - 18h00 GMT</span>
                    </div>
                </div>

                <div class="social-links mt-4">
                    <a href="https://www.facebook.com/share/r/18SYrbWQMw/" class="fab fa-facebook-f" title="Facebook" target="_blank" rel="noopener"></a>
                    <a href="https://www.instagram.com/au_dela_desfaits?igsh=MXB4YmZyYmFndmplMw==" class="fab fa-instagram" title="Instagram" target="_blank" rel="noopener"></a>
                    <a href="https://www.linkedin.com/company/au-del%C3%A0-des-faits/" class="fab fa-linkedin-in" title="LinkedIn" target="_blank" rel="noopener"></a>
                    <a href="https://youtube.com/@audeladesfaits24?si=rwrvJvKqaD1H1K9g" class="fab fa-youtube" title="YouTube" target="_blank" rel="noopener"></a>
                    <a href="https://www.tiktok.com/@audeladesfaits2024?_r=1&_t=ZS-96M1YTFoZyq" class="fab fa-tiktok" title="TikTok" target="_blank" rel="noopener"></a>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="contact-command card h-100">
                <div class="card-body p-4 p-lg-5">
                    <span class="section-kicker">Orientation</span>
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-4">
                        <h2 class="h3 fw-bold mt-3 mb-0">Choisissez le bon point d'entrée</h2>
                        <a href="{{ route('appointment.fr') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-plus me-2"></i>Planifier
                        </a>
                    </div>

                    <div class="contact-path-grid">
                        <a class="contact-path" href="mailto:halimatouk484@gmail.com?subject=Demande%20m%C3%A9dia">
                            <i class="fas fa-microphone-lines"></i>
                            <strong>Demande média</strong>
                            <span>Interview, intervention, citation, émission ou éclairage sociologique.</span>
                        </a>
                        <a class="contact-path" href="{{ route('appointment.fr') }}">
                            <i class="fas fa-handshake-angle"></i>
                            <strong>Collaboration</strong>
                            <span>Projet éditorial, institutionnel, associatif ou de recherche appliquée.</span>
                        </a>
                        <a class="contact-path" href="{{ route('services') }}">
                            <i class="fas fa-compass-drafting"></i>
                            <strong>Accompagnement</strong>
                            <span>Conseil, stratégie de communication, analyse sociale ou formation.</span>
                        </a>
                        <a class="contact-path" href="{{ route('medias') }}">
                            <i class="fas fa-photo-film"></i>
                            <strong>Portfolio média</strong>
                            <span>Photos, vidéos, interventions et contenus publics disponibles.</span>
                        </a>
                    </div>

                    <div class="contact-brief mt-4">
                        <div>
                            <span class="section-kicker">Pour aller vite</span>
                            <h3 class="h5 fw-bold mt-2 mb-3">Ajoutez ces éléments dans votre premier message</h3>
                        </div>
                        <ul>
                            <li><i class="fas fa-check"></i>Votre organisation et le contexte de la demande.</li>
                            <li><i class="fas fa-check"></i>Le format souhaité: échange, média, conférence, conseil.</li>
                            <li><i class="fas fa-check"></i>La date cible, le fuseau horaire et le niveau d'urgence.</li>
                            <li><i class="fas fa-check"></i>Les liens ou documents utiles à consulter.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-scope page-hero p-4 p-lg-5 mb-5">
    <div class="row g-4 align-items-stretch">
        <div class="col-md-4">
            <div class="scope-item">
                <i class="fas fa-globe-africa"></i>
                <h2 class="h4 fw-bold"><span class="gradient-text">Zone d'intervention</span></h2>
                <p>Afrique de l'Ouest, France, Union européenne et institutions internationales.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="scope-item">
                <i class="fas fa-hourglass-half"></i>
                <h2 class="h4 fw-bold"><span class="gradient-text">Délai de réponse</span></h2>
                <p>Les demandes complètes sont généralement traitées sous 48 heures ouvrables.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="scope-item">
                <i class="fas fa-lightbulb"></i>
                <h2 class="h4 fw-bold"><span class="gradient-text">Sujets privilégiés</span></h2>
                <p>Justice sociale, médias, droits humains, institutions et dynamiques africaines.</p>
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
        margin-top: 1rem;
        padding: 1rem 0 0;
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
        text-decoration: none;
        transition: transform .24s ease, border-color .24s ease, box-shadow .24s ease;
    }
    .contact-line:hover {
        border-color: rgba(245, 158, 11, .42);
        box-shadow: 0 16px 34px rgba(15, 23, 42, .08);
        transform: translateX(8px);
    }
    .contact-line i,
    .contact-path i,
    .scope-item i {
        align-items: center;
        display: inline-flex;
        flex: 0 0 auto;
        justify-content: center;
    }
    .contact-line i {
        background: linear-gradient(135deg, #020617, #2563eb);
        border-radius: 16px;
        box-shadow: 0 12px 24px rgba(37, 99, 235, .24);
        color: #fff;
        height: 46px;
        width: 46px;
    }
    .contact-line strong {
        color: #020617;
        display: block;
    }
    .contact-line span {
        color: #475569;
        text-decoration: none;
    }
    .contact-command {
        background:
            linear-gradient(180deg, rgba(255,255,255,.98), rgba(248,250,252,.92)),
            radial-gradient(circle at 88% 10%, rgba(56,189,248,.22), transparent 14rem);
    }
    .contact-path-grid {
        display: grid;
        gap: 1rem;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    .contact-path {
        background: rgba(255, 255, 255, .78);
        border: 1px solid rgba(148, 163, 184, .22);
        border-radius: 20px;
        color: #475569;
        padding: 1.1rem;
        text-decoration: none;
        transition: transform .24s ease, border-color .24s ease, box-shadow .24s ease;
    }
    .contact-path:hover {
        border-color: rgba(37, 99, 235, .34);
        box-shadow: 0 18px 38px rgba(15, 23, 42, .09);
        color: #475569;
        transform: translateY(-5px);
    }
    .contact-path i {
        background: #eff6ff;
        border-radius: 16px;
        color: #2563eb;
        height: 46px;
        margin-bottom: .9rem;
        width: 46px;
    }
    .contact-path strong {
        color: #020617;
        display: block;
        font-size: 1rem;
        margin-bottom: .35rem;
    }
    .contact-path span {
        display: block;
        font-size: .92rem;
        line-height: 1.55;
    }
    .contact-brief {
        background: #0f172a;
        border-radius: 22px;
        padding: 1.25rem;
    }
    .contact-brief h3 {
        color: #fff;
    }
    .contact-brief ul {
        display: grid;
        gap: .75rem;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .contact-brief li {
        align-items: flex-start;
        color: rgba(226, 232, 240, .9) !important;
        display: flex;
        gap: .7rem;
        line-height: 1.55;
    }
    .contact-brief li i {
        color: #fbbf24;
        margin-top: .2rem;
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
        background: rgba(255, 255, 255, .14);
        border-radius: 16px;
        color: #fbbf24;
        height: 48px;
        margin-bottom: 1rem;
        width: 48px;
    }
    .scope-item p {
        margin-bottom: 0;
    }
    @media (max-width: 767.98px) {
        .contact-path-grid {
            grid-template-columns: 1fr;
        }
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
    }
    @keyframes contact-orbit {
        from { transform: translate3d(0, 0, 0) rotate(0deg); opacity: .45; }
        to { transform: translate3d(18px, -22px, 0) rotate(18deg); opacity: .9; }
    }
</style>
@endpush
