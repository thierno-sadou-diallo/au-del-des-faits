@extends('frontend.layout')

@section('content')
@php
    $steps = [
        'pending' => ['label' => 'En attente', 'text' => 'Votre demande est recue et attend la validation admin.', 'rank' => 1],
        'confirmed' => ['label' => 'Approuvee', 'text' => 'Votre rendez-vous est approuve. Un email de confirmation peut vous etre envoye.', 'rank' => 2],
        'completed' => ['label' => 'Terminee', 'text' => 'Le rendez-vous est marque comme termine.', 'rank' => 3],
        'cancelled' => ['label' => 'Non approuvee', 'text' => 'La demande n a pas ete retenue ou le creneau a ete annule.', 'rank' => 0],
    ];
    $current = $appointment ? ($steps[$appointment->status] ?? $steps['pending']) : null;
@endphp

<section class="status-hero page-hero p-4 p-lg-5 mb-5 african-decor">
    <div class="row align-items-end g-4">
        <div class="col-lg-8">
            <span class="badge mb-3">Suivi</span>
            <h1 class="display-3 fw-bold mb-3"><span class="gradient-text">Suivre une demande</span></h1>
            <p class="lead mb-0">Renseignez la reference recue apres l'envoi pour verifier si le rendez-vous est en attente, approuve ou annule.</p>
        </div>
    </div>
</section>

<section class="mb-5">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="status-card p-4 p-lg-5">
                <span class="section-kicker">Recherche</span>
                <h2 class="h4 fw-bold mt-3 mb-4">Retrouver ma demande</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('appointment.status.lookup') }}" class="row g-3">
                    @csrf
                    <div class="col-12">
                        <label for="tracking_token" class="form-label fw-bold">Reference *</label>
                        <input type="text" name="tracking_token" id="tracking_token" class="form-control" value="{{ old('tracking_token', $appointment?->tracking_token) }}" placeholder="ADF-2026-XXXXXXXXXX" required>
                    </div>
                    <div class="col-12">
                        <label for="email" class="form-label fw-bold">Email utilise *</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $appointment?->email) }}" required>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">
                            <i class="fas fa-magnifying-glass me-2"></i>Verifier le statut
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="status-card p-4 p-lg-5">
                <span class="section-kicker">Etat</span>
                @if($appointment)
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                        <div>
                            <h2 class="h3 fw-bold mt-3 mb-2">{{ $current['label'] }}</h2>
                            <p class="mb-0">{{ $current['text'] }}</p>
                        </div>
                        <span class="status-pill status-{{ $appointment->status }}">{{ $current['label'] }}</span>
                    </div>

                    <div class="status-timeline">
                        <div class="timeline-step {{ $current['rank'] >= 1 ? 'is-active' : '' }}">
                            <span>1</span>
                            <strong>Demande envoyee</strong>
                        </div>
                        <div class="timeline-step {{ $current['rank'] >= 2 ? 'is-active' : '' }}">
                            <span>2</span>
                            <strong>Validation admin</strong>
                        </div>
                        <div class="timeline-step {{ $current['rank'] >= 3 ? 'is-active' : '' }}">
                            <span>3</span>
                            <strong>Rendez-vous termine</strong>
                        </div>
                    </div>

                    <div class="request-details mt-4">
                        <p><strong>Reference :</strong> {{ $appointment->tracking_token }}</p>
                        <p><strong>Objet :</strong> {{ $appointment->subject }}</p>
                        <p><strong>Creneau :</strong>
                            {{ $appointment->availabilitySlot?->start_time->format('d/m/Y H:i') ?? 'A definir' }}
                            @if($appointment->availabilitySlot)
                                - {{ $appointment->availabilitySlot->end_time->format('H:i') }}
                            @endif
                        </p>
                        <p class="mb-0"><strong>Demandee le :</strong> {{ $appointment->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                @else
                    <h2 class="h3 fw-bold mt-3 mb-3">Entrez votre reference</h2>
                    <p class="mb-0">Votre statut apparaitra ici apres verification de la reference et de l'email.</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .status-hero { min-height: 360px; }
    .status-card {
        background: linear-gradient(180deg, rgba(255,255,255,.98), rgba(248,250,252,.94));
        border: 1px solid rgba(148, 163, 184, .24);
        border-radius: 24px;
        box-shadow: 0 20px 58px rgba(15, 23, 42, .1);
        height: 100%;
    }
    .status-pill {
        align-self: flex-start;
        border-radius: 999px;
        font-size: .82rem;
        font-weight: 900;
        padding: .55rem .9rem;
        white-space: nowrap;
    }
    .status-pending { background: #fff7ed; color: #b45309; }
    .status-confirmed,
    .status-completed { background: #ecfdf5; color: #047857; }
    .status-cancelled { background: #fff1f2; color: #be123c; }
    .status-timeline {
        display: grid;
        gap: .85rem;
    }
    .timeline-step {
        align-items: center;
        background: #f8fafc;
        border: 1px solid rgba(148, 163, 184, .22);
        border-radius: 16px;
        display: flex;
        gap: .85rem;
        padding: .9rem;
    }
    .timeline-step span {
        align-items: center;
        background: #e2e8f0;
        border-radius: 999px;
        color: #475569;
        display: inline-flex;
        font-weight: 900;
        height: 34px;
        justify-content: center;
        width: 34px;
    }
    .timeline-step.is-active {
        background: #eff6ff;
        border-color: rgba(37, 99, 235, .28);
    }
    .timeline-step.is-active span {
        background: #2563eb;
        color: #fff;
    }
    .request-details {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, .2);
        border-radius: 18px;
        padding: 1rem;
    }
</style>
@endpush
