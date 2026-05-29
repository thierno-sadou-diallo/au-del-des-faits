@extends('frontend.layout')

@section('content')
<section class="appointment-hero page-hero p-4 p-lg-5 mb-5 african-decor">
    <div class="row align-items-end g-4">
        <div class="col-lg-8">
            <span class="badge mb-3">Rendez-vous</span>
            <h1 class="display-3 fw-bold mb-3"><span class="gradient-text">Demander un rendez-vous</span></h1>
            <p class="lead mb-4">Choisissez un créneau disponible, présentez votre besoin, puis suivez l’évolution de votre demande avec une référence privée.</p>
            <div class="appointment-hero-actions">
                <a href="#appointment-form" class="btn btn-primary btn-lg">
                    <i class="fas fa-calendar-check me-2"></i>Choisir un créneau
                </a>
                <a href="{{ route('appointment.status') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-list-check me-2"></i>Suivre ma demande
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="appointment-signal">
                <span class="section-kicker">Processus</span>
                <div class="signal-row">
                    <strong>1</strong>
                    <span>Demande reçue</span>
                </div>
                <div class="signal-row">
                    <strong>2</strong>
                    <span>Validation admin</span>
                </div>
                <div class="signal-row">
                    <strong>3</strong>
                    <span>Confirmation par email</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mb-5">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="appointment-profile art-card h-100 p-4 p-lg-5">
                <span class="section-kicker">Disponibilités</span>
                <h2 class="h3 fw-bold mt-3 mb-4"><span class="gradient-text">Sélectionnez le moment qui vous convient.</span></h2>

                <div class="slot-list">
                    @forelse ($slots as $slot)
                        <button
                            type="button"
                            class="slot-option"
                            data-slot-id="{{ $slot->id }}"
                            data-slot-label="{{ $slot->start_time->format('d/m/Y H:i') }} - {{ $slot->end_time->format('H:i') }}"
                        >
                            <span>
                                <strong>{{ $slot->start_time->translatedFormat('d M Y') }}</strong>
                                <small>{{ $slot->start_time->format('H:i') }} - {{ $slot->end_time->format('H:i') }}</small>
                                @if($slot->description)
                                    <small class="slot-description">{{ $slot->description }}</small>
                                @endif
                            </span>
                            <em>{{ $slot->max_appointments - $slot->current_appointments }} place(s)</em>
                        </button>
                    @empty
                        <div class="alert alert-warning mb-0">
                            Aucun créneau n’est disponible pour le moment. Vous pouvez envoyer un message via la page contact.
                        </div>
                    @endforelse
                </div>

                <div class="appointment-note mt-4">
                    <i class="fas fa-shield-halved"></i>
                    <p class="mb-0">Après envoi, une référence de suivi vous permet de consulter l’état de la demande sans créer de compte.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="appointment-form-card card h-100" id="appointment-form">
                <div class="card-body p-4 p-lg-5">
                    <span class="section-kicker">Demande</span>
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-4">
                        <h2 class="h3 fw-bold mt-3 mb-0">Informations du rendez-vous</h2>
                        <a href="{{ route('appointment.status') }}" class="status-link">
                            <i class="fas fa-magnifying-glass me-2"></i>Suivre une demande
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('appointment.store') }}" class="row g-3" id="appointmentBookingForm">
                        @csrf
                        <input type="hidden" id="availability_slot_id" name="availability_slot_id" value="{{ old('availability_slot_id') }}" required>

                        <div id="slot-selection-error" class="col-12 d-none">
                            <div class="alert alert-warning mb-0">
                                Veuillez sélectionner un créneau disponible dans la liste à gauche avant d’envoyer votre demande.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold">Nom complet *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name') }}">
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}">
                            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold">Téléphone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="organization" class="form-label fw-bold">Organisation</label>
                            <input type="text" class="form-control" id="organization" name="organization" value="{{ old('organization') }}">
                        </div>
                        <div class="col-12">
                            <label for="subject" class="form-label fw-bold">Objet *</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" required value="{{ old('subject') }}" placeholder="Ex: collaboration, intervention media, accompagnement">
                            @error('subject')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label fw-bold">Contexte de la demande *</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                            @error('message')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100" id="appointment-submit" @if($slots->isEmpty()) disabled @endif>
                                <i class="fas fa-paper-plane me-2"></i>Envoyer la demande
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .appointment-hero { min-height: 420px; padding-top: clamp(2rem, 5vw, 5rem) !important; }
    .appointment-hero .lead { max-width: 780px; }
    .appointment-hero-actions { display: flex; flex-wrap: wrap; gap: .85rem; }
    .appointment-signal {
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
        padding-top: 1rem;
    }
    .signal-row strong {
        color: #fff;
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        line-height: 1;
        min-width: 42px;
    }
    .signal-row span { color: rgba(226, 232, 240, .9); font-weight: 800; }
    .appointment-profile,
    .appointment-form-card {
        background: linear-gradient(180deg, rgba(255,255,255,.98), rgba(248,250,252,.94));
    }
    .slot-list { display: grid; gap: .85rem; }
    .slot-option {
        align-items: center;
        background: rgba(255, 255, 255, .82);
        border: 1px solid rgba(148, 163, 184, .24);
        border-radius: 18px;
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem;
        text-align: left;
        width: 100%;
    }
    .slot-option:hover,
    .slot-option.is-selected {
        border-color: rgba(37, 99, 235, .48);
        box-shadow: 0 16px 34px rgba(15, 23, 42, .08);
        transform: translateY(-2px);
    }
    .slot-option strong,
    .slot-option small { display: block; }
    .slot-option small { color: #64748b; font-weight: 800; margin-top: .2rem; }
    .slot-option .slot-description {
        color: #475569;
        font-weight: 700;
        line-height: 1.45;
        max-width: 28rem;
    }
    .slot-option em {
        background: #eff6ff;
        border-radius: 999px;
        color: #2563eb;
        font-size: .78rem;
        font-style: normal;
        font-weight: 900;
        padding: .4rem .7rem;
        white-space: nowrap;
    }
    .appointment-note {
        align-items: flex-start;
        background: #fff7ed;
        border: 1px solid rgba(245, 158, 11, .25);
        border-radius: 18px;
        display: flex;
        gap: .85rem;
        padding: 1rem;
    }
    .appointment-note i { color: #b45309; margin-top: .25rem; }
    .status-link {
        border: 1px solid rgba(37,99,235,.22);
        border-radius: 999px;
        color: #2563eb;
        font-size: .88rem;
        font-weight: 900;
        padding: .55rem .85rem;
        text-decoration: none;
    }
    @media (max-width: 575.98px) {
        .appointment-hero-actions .btn { width: 100%; }
        .slot-option { align-items: flex-start; flex-direction: column; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('availability_slot_id');
        const error = document.getElementById('slot-selection-error');
        const form = document.getElementById('appointmentBookingForm');
        const submit = document.getElementById('appointment-submit');

        document.querySelectorAll('.slot-option').forEach((button) => {
            if (input.value && input.value === button.dataset.slotId) {
                button.classList.add('is-selected');
            }

            button.addEventListener('click', () => {
                document.querySelectorAll('.slot-option').forEach((item) => item.classList.remove('is-selected'));
                button.classList.add('is-selected');
                input.value = button.dataset.slotId;
                error.classList.add('d-none');
                submit.disabled = false;
                form.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });

        form.addEventListener('submit', (event) => {
            if (! input.value) {
                event.preventDefault();
                error.classList.remove('d-none');
            }
        });
    });
</script>
@endpush
