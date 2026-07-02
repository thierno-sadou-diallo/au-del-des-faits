@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Calendrier de disponibilité</h1>
        <a href="{{ route('admin.appointments.pending-requests') }}" class="btn btn-warning">
            <i class="fas fa-exclamation-circle me-2"></i>Demandes en attente
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>{{ $currentDate->locale('fr')->monthName }} {{ $currentDate->year }}
                </h5>
                <div>
                    <a href="{{ route('admin.availability-slots.calendar', ['year' => $currentDate->copy()->subMonth()->year, 'month' => $currentDate->copy()->subMonth()->month]) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <span class="mx-2">{{ $currentDate->format('F Y') }}</span>
                    <a href="{{ route('admin.availability-slots.calendar', ['year' => $currentDate->copy()->addMonth()->year, 'month' => $currentDate->copy()->addMonth()->month]) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>

            <!-- Calendrier -->
            <div class="calendar-grid mb-4">
                <div class="calendar-header">
                    <div class="calendar-day-header">Lun</div>
                    <div class="calendar-day-header">Mar</div>
                    <div class="calendar-day-header">Mer</div>
                    <div class="calendar-day-header">Jeu</div>
                    <div class="calendar-day-header">Ven</div>
                    <div class="calendar-day-header">Sam</div>
                    <div class="calendar-day-header">Dim</div>
                </div>

                <div class="calendar-body">
                    @php
                        $firstDay = $currentDate->copy()->startOfMonth();
                        $lastDay = $currentDate->copy()->endOfMonth();
                        $previousDays = $firstDay->dayOfWeek === 0 ? 6 : $firstDay->dayOfWeek - 1;
                        $startDate = $firstDay->copy()->subDays($previousDays);
                    @endphp

                    @for ($i = 0; $i < 42; $i++)
                        @php
                            $date = $startDate->copy()->addDays($i);
                            $isCurrentMonth = $date->month === $currentDate->month;
                            $isAvailable = in_array($date->day, $availableDays) && $isCurrentMonth;
                            $isPast = $date->isPast();
                        @endphp

                        <div class="calendar-day {{ !$isCurrentMonth ? 'other-month' : '' }} {{ $isPast ? 'past' : '' }}">
                            <div class="day-number">{{ $date->day }}</div>
                            @if ($isCurrentMonth && !$isPast)
                                <form action="{{ route('admin.availability-slots.toggle-day') }}" method="POST" class="toggle-form">
                                    @csrf
                                    <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}">
                                    <button type="submit" class="btn btn-sm {{ $isAvailable ? 'btn-success' : 'btn-outline-success' }}">
                                        <i class="fas {{ $isAvailable ? 'fa-check' : 'fa-plus' }}"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>

            <div class="text-muted small">
                <i class="fas fa-info-circle me-2"></i>Cliquez sur les jours pour les marquer comme disponibles ou non.
            </div>
        </div>
    </div>
</div>

<style>
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 10px;
        margin: 20px 0;
    }

    .calendar-header {
        display: contents;
    }

    .calendar-day-header {
        font-weight: bold;
        text-align: center;
        padding: 10px;
        background: #f5f5f5;
        border-radius: 4px;
        font-size: 0.9rem;
    }

    .calendar-body {
        display: contents;
    }

    .calendar-day {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        min-height: 120px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .calendar-day:hover {
        border-color: #0d6efd;
        box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.1);
    }

    .calendar-day.other-month {
        background: #f9f9f9;
        color: #ccc;
    }

    .calendar-day.past {
        background: #f5f5f5;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .day-number {
        font-weight: bold;
        font-size: 1.2rem;
    }

    .toggle-form {
        width: 100%;
    }

    .toggle-form button {
        width: 100%;
    }
</style>
@endsection
