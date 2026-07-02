@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Demandes de rendez-vous en attente</h1>
        <a href="{{ route('admin.availability-slots.calendar') }}" class="btn btn-primary">
            <i class="fas fa-calendar-alt me-2"></i>Gérer le calendrier
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($appointments->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>Aucune demande en attente d'approbation.
        </div>
    @else
        <div class="row g-3">
            @foreach ($appointments as $appointment)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $appointment->name }}</h5>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-envelope me-2"></i>{{ $appointment->email }}
                            </p>
                            @if ($appointment->phone)
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-phone me-2"></i>{{ $appointment->phone }}
                                </p>
                            @endif
                            <p class="text-muted small mb-2">
                                <i class="fas fa-calendar me-2"></i>
                                {{ $appointment->appointment_date->locale('fr')->format('d F Y') }}
                            </p>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-building me-2"></i>
                                {{ $appointment->organization ?? 'N/A' }}
                            </p>

                            <div class="mb-3">
                                <h6 class="text-secondary">Sujet</h6>
                                <p class="small">{{ $appointment->subject }}</p>
                            </div>

                            <div class="mb-3">
                                <h6 class="text-secondary">Message</h6>
                                <p class="small text-muted">{{ Str::limit($appointment->message, 150) }}</p>
                            </div>

                            <div class="d-grid gap-2">
                                <form action="{{ route('admin.appointments.approve', $appointment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check me-2"></i>Approuver
                                    </button>
                                </form>
                                <form action="{{ route('admin.appointments.reject', $appointment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr?')">
                                        <i class="fas fa-times me-2"></i>Rejeter
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $appointments->links() }}
        </div>
    @endif
</div>
@endsection
