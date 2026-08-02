@extends('frontend.layout')

@section('content')
<section class="thankyou page-hero p-4 p-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="thankyou-panel">
                <div class="text-center mb-4">
                    <span class="badge bg-primary mb-3">Demande envoyee</span>
                    <h1 class="h2 fw-bold">Merci, votre demande est bien recue</h1>
                    <p class="text-muted mb-0">Elle apparait maintenant dans le dashboard admin pour validation.</p>
                </div>

                @if($appointment)
                    <div class="request-summary">
                        <h2 class="h5 fw-semibold mb-3">Reference de suivi</h2>
                        <div class="tracking-code">{{ $appointment->tracking_token }}</div>
                        <p class="small text-muted mb-0 mt-2">Gardez cette reference avec votre email pour suivre l'evolution de la demande.</p>
                    </div>

                    <div class="request-summary">
                        <h2 class="h5 fw-semibold mb-3">Resume</h2>
                        <p class="mb-2"><strong>Nom :</strong> {{ $appointment->name }}</p>
                        <p class="mb-2"><strong>Email :</strong> {{ $appointment->email }}</p>
                        <p class="mb-2"><strong>Objet :</strong> {{ $appointment->subject }}</p>
                        <p class="mb-0"><strong>Date demandee :</strong>
                            {{ $appointment->appointment_date?->format('d/m/Y') ?? 'A definir' }}
                            @if($appointment->is_approved)
                                <span class="badge bg-success ms-2">Confirmee</span>
                            @else
                                <span class="badge bg-warning text-dark ms-2">En attente</span>
                            @endif
                        </p>
                    </div>
                @endif

                <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
                    @if($appointment)
                        <a href="{{ route('appointment.status.show', $appointment->tracking_token) }}" class="btn btn-primary">Verifier avec mon email</a>
                    @endif
                    <a href="{{ route('appointment') }}" class="btn btn-outline-secondary">Nouvelle demande</a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">Accueil</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .thankyou-panel {
        background: linear-gradient(180deg, rgba(255,255,255,.98), rgba(248,250,252,.94));
        border: 1px solid rgba(148, 163, 184, .24);
        border-radius: 24px;
        box-shadow: 0 24px 70px rgba(15, 23, 42, .12);
        padding: clamp(1.5rem, 4vw, 3rem);
    }
    .request-summary {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, .22);
        border-radius: 18px;
        margin-top: 1rem;
        padding: 1.25rem;
    }
    .tracking-code {
        background: #020617;
        border-radius: 14px;
        color: #fbbf24;
        font-size: clamp(1rem, 3vw, 1.35rem);
        font-weight: 900;
        letter-spacing: .06em;
        padding: 1rem;
        text-align: center;
        word-break: break-word;
    }
</style>
@endpush
