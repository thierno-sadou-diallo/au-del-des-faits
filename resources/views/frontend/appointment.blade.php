@extends('frontend.layout')

@section('content')
<section class="appointment-hero page-hero p-3 p-lg-4 mb-4 african-decor">
    <div class="row align-items-end g-3">
        <div class="col-lg-8">
            <span class="badge mb-2" style="font-size: 0.8rem;">Rendez-vous</span>
            <h1 class="display-4 fw-bold mb-2"><span class="gradient-text">Demander un rendez-vous</span></h1>
            <p class="lead mb-3" style="font-size: 1rem;">Sélectionnez une date disponible, présentez votre besoin, puis suivez votre demande avec une référence privée.</p>
            <div class="appointment-hero-actions">
                <a href="#appointment-form" class="btn btn-primary" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                    <i class="fas fa-calendar-check me-1"></i>Choisir une date
                </a>
                <a href="{{ route('appointment.status') }}" class="btn btn-outline-primary" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                    <i class="fas fa-list-check me-1"></i>Suivre ma demande
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="appointment-signal">
                <span class="section-kicker" style="font-size: 0.8rem;">Processus</span>
                <div class="signal-row" style="gap: 0.8rem; padding-top: 0.8rem; margin-top: 0.8rem;">
                    <strong style="font-size: 1.4rem;">1</strong>
                    <span style="font-size: 0.9rem;">Demande reçue</span>
                </div>
                <div class="signal-row" style="gap: 0.8rem; padding-top: 0.8rem; margin-top: 0.8rem;">
                    <strong style="font-size: 1.4rem;">2</strong>
                    <span style="font-size: 0.9rem;">Validation admin</span>
                </div>
                <div class="signal-row" style="gap: 0.8rem; padding-top: 0.8rem; margin-top: 0.8rem;">
                    <strong style="font-size: 1.4rem;">3</strong>
                    <span style="font-size: 0.9rem;">Confirmation email</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mb-5" id="appointment-form">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="appointment-profile art-card h-100 p-3 p-lg-4">
                <span class="section-kicker">Sélectionner une date</span>
                <h2 class="h5 fw-bold mt-2 mb-3"><span class="gradient-text">Dates disponibles</span></h2>

                <!-- Calendrier pour sélectionner une date -->
                <div class="calendar-selector">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <button class="btn btn-sm btn-outline-primary" id="prev-month" type="button" style="padding: 0.35rem 0.55rem; font-size: 0.8rem;">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h6 id="month-display" class="mb-0" style="font-size: 0.95rem;">{{ $currentDate->locale('fr')->monthName }} {{ $currentDate->year }}</h6>
                        <button class="btn btn-sm btn-outline-primary" id="next-month" type="button" style="padding: 0.35rem 0.55rem; font-size: 0.8rem;">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <!-- Message si pas de dates disponibles -->
                    <div id="no-available-dates" class="alert alert-info alert-sm mb-3" style="display: none;">
                        <i class="fas fa-calendar-times me-2"></i>
                        <small>Aucune date disponible ce mois-ci. Vous pouvez proposer une date spécifique ci-dessous.</small>
                    </div>

                    <!-- Grille calendaire -->
                    <div class="calendar-grid-user mb-2">
                        <div class="calendar-day-header">Lun</div>
                        <div class="calendar-day-header">Mar</div>
                        <div class="calendar-day-header">Mer</div>
                        <div class="calendar-day-header">Jeu</div>
                        <div class="calendar-day-header">Ven</div>
                        <div class="calendar-day-header">Sam</div>
                        <div class="calendar-day-header">Dim</div>

                        <div id="calendar-days"></div>
                    </div>

                    <!-- Légende simplifiée -->
                    <div class="date-legend">
                        <div class="legend-item">
                            <span class="legend-color available"></span>
                            <small>Disponible (approuvé automatiquement)</small>
                        </div>
                    </div>
                </div>

                <div class="appointment-note mt-3">
                    <i class="fas fa-shield-halved"></i>
                    <p class="mb-0"><small>Une référence de suivi vous permet de consulter l'état sans créer de compte.</small></p>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="appointment-form-card card h-100">
                <div class="card-body p-3 p-lg-4">
                    <span class="section-kicker">Formulaire</span>
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-2 mb-3">
                        <h2 class="h5 fw-bold mt-2 mb-0">Vos informations</h2>
                        <a href="{{ route('appointment.status') }}" class="status-link" style="font-size: 0.8rem; padding: 0.4rem 0.7rem;">
                            <i class="fas fa-magnifying-glass me-1"></i>Suivre
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-sm" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-sm">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('appointment.store') }}" class="row g-2" id="appointmentForm">
                        @csrf

                        <!-- Date sélectionnée -->
                        <input type="hidden" id="appointment_type" name="appointment_type" value="">
                        <input type="hidden" id="appointment_date" name="appointment_date" value="">

                        <div id="selected-date-info" class="col-12 d-none">
                            <div class="alert alert-info alert-sm">
                                <i class="fas fa-calendar me-1"></i>
                                <strong>Date:</strong> <span id="selected-date-display"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold" style="font-size: 0.9rem;">Nom *</label>
                            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name') }}">
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold" style="font-size: 0.9rem;">Email *</label>
                            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}">
                            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold" style="font-size: 0.9rem;">Téléphone</label>
                            <input type="tel" class="form-control form-control-sm" id="phone" name="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="organization" class="form-label fw-bold" style="font-size: 0.9rem;">Organisation</label>
                            <input type="text" class="form-control form-control-sm" id="organization" name="organization" value="{{ old('organization') }}">
                        </div>
                        <div class="col-12">
                            <label for="subject" class="form-label fw-bold" style="font-size: 0.9rem;">Objet *</label>
                            <input type="text" class="form-control form-control-sm @error('subject') is-invalid @enderror" id="subject" name="subject" required value="{{ old('subject') }}" placeholder="Ex: collaboration, accompagnement">
                            @error('subject')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label fw-bold" style="font-size: 0.9rem;">Contexte *</label>
                            <textarea class="form-control form-control-sm @error('message') is-invalid @enderror" id="message" name="message" rows="4" required>{{ old('message') }}</textarea>
                            @error('message')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm w-100" id="appointment-submit" disabled>
                                <i class="fas fa-paper-plane me-1"></i>Envoyer la demande
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

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

    .calendar-grid-user {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 6px;
    }

    .calendar-day-header {
        font-weight: bold;
        text-align: center;
        padding: 6px 4px;
        background: #f5f5f5;
        border-radius: 4px;
        font-size: 0.75rem;
        grid-column: span 1;
    }

    .calendar-day-cell {
        border: 2px solid #ddd;
        border-radius: 6px;
        padding: 4px 2px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: white;
        font-size: 0.8rem;
        min-height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
    }

    .calendar-day-cell:hover:not(.other-month):not(.past):not(.unavailable) {
        border-color: #0d6efd;
        box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.15);
        transform: translateY(-1px);
    }

    .calendar-day-cell.other-month {
        background: #f9f9f9;
        color: #ccc;
        cursor: not-allowed;
    }

    .calendar-day-cell.past,
    .calendar-day-cell.unavailable {
        background: #f5f5f5;
        color: #bbb;
        cursor: not-allowed;
        border-color: #ddd;
    }

    .calendar-day-cell.available {
        border-color: #28a745;
        background: rgba(40, 167, 69, 0.08);
        color: #155724;
    }

    .calendar-day-cell.available:hover {
        background: rgba(40, 167, 69, 0.15);
    }

    .calendar-day-cell.available.selected {
        background: #28a745;
        color: white;
        border-color: #28a745;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
    }

    .date-legend {
        display: flex;
        gap: 12px;
        padding: 8px;
        background: #f9f9f9;
        border-radius: 6px;
        margin-top: 8px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        margin: 0;
    }

    .legend-color {
        width: 16px;
        height: 16px;
        border-radius: 3px;
        border: 2px solid;
        flex-shrink: 0;
    }

    .legend-color.available {
        background: rgba(40, 167, 69, 0.1);
        border-color: #28a745;
    }

    .appointment-note {
        align-items: flex-start;
        background: #fff7ed;
        border: 1px solid rgba(245, 158, 11, .25);
        border-radius: 12px;
        display: flex;
        gap: 0.6rem;
        padding: 0.75rem;
    }

    .appointment-note i { color: #b45309; margin-top: .15rem; font-size: 0.9rem; flex-shrink: 0; }

    .status-link {
        border: 1px solid rgba(37,99,235,.22);
        border-radius: 999px;
        color: #2563eb;
        font-weight: 900;
        text-decoration: none;
        white-space: nowrap;
    }

    .status-link:hover {
        text-decoration: underline;
    }

    .alert-sm {
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        margin-bottom: 0.75rem;
    }

    .form-control-sm {
        font-size: 0.9rem;
        padding: 0.35rem 0.55rem;
        height: auto;
    }

    @media (max-width: 575.98px) {
        .appointment-hero-actions .btn { width: 100%; }
        .calendar-grid-user { gap: 4px; }
        .calendar-day-cell { min-height: 40px; font-size: 0.75rem; }
        .date-legend { flex-direction: column; gap: 6px; }
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentMonth = {{ $month }};
    let currentYear = {{ $year }};
    const availableDays = {!! json_encode($availableDays) !!};
    
    function generateCalendar() {
        const firstDay = new Date(currentYear, currentMonth - 1, 1);
        const lastDay = new Date(currentYear, currentMonth, 0);
        const daysInMonth = lastDay.getDate();
        const startingDayOfWeek = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1;

        const monthNames = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin',
                          'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
        document.getElementById('month-display').textContent = 
            monthNames[currentMonth - 1] + ' ' + currentYear;

        let calendarDays = '';
        let hasAvailableDates = false;
        let date = new Date(currentYear, currentMonth - 1, 1);
        date.setDate(date.getDate() - startingDayOfWeek);

        for (let i = 0; i < 42; i++) {
            const isCurrentMonth = date.getMonth() === currentMonth - 1;
            const isPast = date < new Date();
            const dayNumber = date.getDate();
            const isAvailable = isCurrentMonth && availableDays.includes(dayNumber);
            const dateStr = date.getFullYear() + '-' + 
                          String(date.getMonth() + 1).padStart(2, '0') + '-' + 
                          String(date.getDate()).padStart(2, '0');

            if (isAvailable && isCurrentMonth) {
                hasAvailableDates = true;
            }

            let classes = 'calendar-day-cell';
            if (!isCurrentMonth) classes += ' other-month';
            if (isPast && isCurrentMonth) classes += ' past';
            if (isAvailable && isCurrentMonth) classes += ' available';
            if (!isAvailable && isCurrentMonth && !isPast) classes += ' unavailable';

            calendarDays += `<div class="${classes}" data-date="${dateStr}" data-day="${dayNumber}">
                ${dayNumber}
            </div>`;
            
            date.setDate(date.getDate() + 1);
        }

        document.getElementById('calendar-days').innerHTML = calendarDays;
        
        // Afficher le message si aucune date disponible
        const noAvailMsg = document.getElementById('no-available-dates');
        if (!hasAvailableDates) {
            noAvailMsg.style.display = 'block';
            // Ajouter une option pour demander une date
            if (!document.getElementById('request-date-option')) {
                const requestOption = document.createElement('div');
                requestOption.id = 'request-date-option';
                requestOption.className = 'alert alert-warning mt-2';
                requestOption.innerHTML = '<i class="fas fa-lightbulb me-2"></i><strong>Astuce:</strong> Vous pouvez proposer une date spécifique en remplissant le formulaire ci-dessous.';
                noAvailMsg.parentElement.insertBefore(requestOption, noAvailMsg.nextElementSibling);
            }
        } else {
            noAvailMsg.style.display = 'none';
            const requestOption = document.getElementById('request-date-option');
            if (requestOption) requestOption.remove();
        }

        // Ajouter les event listeners UNIQUEMENT aux dates disponibles
        document.querySelectorAll('.calendar-day-cell.available').forEach(cell => {
            cell.addEventListener('click', selectDate);
        });
    }

    function selectDate(e) {
        const date = e.target.dataset.date;
        
        document.querySelectorAll('.calendar-day-cell').forEach(cell => {
            cell.classList.remove('selected');
        });
        
        e.target.classList.add('selected');
        
        document.getElementById('appointment_date').value = date;
        document.getElementById('appointment_type').value = 'available_day';
        document.getElementById('selected-date-display').textContent = 
            new Date(date + 'T00:00:00').toLocaleDateString('fr-FR', 
                {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'});
        
        document.getElementById('selected-date-info').classList.remove('d-none');
        document.getElementById('appointment-submit').disabled = false;
    }

    document.getElementById('prev-month').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 1) {
            currentMonth = 12;
            currentYear--;
        }
        generateCalendar();
    });

    document.getElementById('next-month').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 12) {
            currentMonth = 1;
            currentYear++;
        }
        generateCalendar();
    });

    generateCalendar();
});
</script>
@endpush

@endsection
