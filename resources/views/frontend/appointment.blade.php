@extends('frontend.layout')

@section('content')
<section class="appointment-hero page-hero p-4 p-lg-5 mb-5 african-decor">
    <div class="row align-items-end g-4">
        <div class="col-lg-8">
            <span class="badge mb-3">Rendez-vous</span>
            <h1 class="display-3 fw-bold mb-3"><span class="gradient-text">Demander un rendez-vous</span></h1>
            <p class="lead mb-4">Sélectionnez une date disponible ou demandez un jour spécifique, présentez votre besoin, puis suivez l'évolution de votre demande avec une référence privée.</p>
            <div class="appointment-hero-actions">
                <a href="#appointment-form" class="btn btn-primary btn-lg">
                    <i class="fas fa-calendar-check me-2"></i>Choisir une date
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

<section class="mb-5" id="appointment-form">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="appointment-profile art-card h-100 p-4 p-lg-5">
                <span class="section-kicker">Sélectionner une date</span>
                <h2 class="h3 fw-bold mt-3 mb-4"><span class="gradient-text">Dates disponibles ou à demander</span></h2>

                <!-- Calendrier pour sélectionner une date -->
                <div class="calendar-selector mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="btn btn-sm btn-outline-primary" id="prev-month" type="button">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h5 id="month-display" class="mb-0">{{ $currentDate->locale('fr')->monthName }} {{ $currentDate->year }}</h5>
                        <button class="btn btn-sm btn-outline-primary" id="next-month" type="button">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <!-- Grille calendaire -->
                    <div class="calendar-grid-user mb-3">
                        <div class="calendar-day-header">Lun</div>
                        <div class="calendar-day-header">Mar</div>
                        <div class="calendar-day-header">Mer</div>
                        <div class="calendar-day-header">Jeu</div>
                        <div class="calendar-day-header">Ven</div>
                        <div class="calendar-day-header">Sam</div>
                        <div class="calendar-day-header">Dim</div>

                        <div id="calendar-days"></div>
                    </div>

                    <!-- Informations sur les dates -->
                    <div class="date-legend">
                        <div class="legend-item">
                            <span class="legend-color available"></span>
                            <span>Date disponible (auto-approuvée)</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color request"></span>
                            <span>Demande à approuver</span>
                        </div>
                    </div>
                </div>

                <div class="appointment-note mt-4">
                    <i class="fas fa-shield-halved"></i>
                    <p class="mb-0">Après envoi, une référence de suivi vous permet de consulter l'état de la demande sans créer de compte.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="appointment-form-card card h-100">
                <div class="card-body p-4 p-lg-5">
                    <span class="section-kicker">Formulaire</span>
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-4">
                        <h2 class="h3 fw-bold mt-3 mb-0">Vos informations</h2>
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

                    <form method="POST" action="{{ route('appointment.store') }}" class="row g-3" id="appointmentForm">
                        @csrf

                        <!-- Date sélectionnée -->
                        <input type="hidden" id="appointment_type" name="appointment_type" value="">
                        <input type="hidden" id="appointment_date" name="appointment_date" value="">

                        <div id="selected-date-info" class="col-12 d-none">
                            <div class="alert alert-info">
                                <i class="fas fa-calendar me-2"></i>
                                <strong>Date sélectionnée:</strong> <span id="selected-date-display"></span>
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
                            <button type="submit" class="btn btn-primary btn-lg w-100" id="appointment-submit" disabled>
                                <i class="fas fa-paper-plane me-2"></i>Envoyer la demande
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
        gap: 8px;
        margin-bottom: 15px;
    }

    .calendar-day-header {
        font-weight: bold;
        text-align: center;
        padding: 8px;
        background: #f5f5f5;
        border-radius: 4px;
        font-size: 0.85rem;
        grid-column: span 1;
    }

    .calendar-day-cell {
        border: 2px solid #ddd;
        border-radius: 8px;
        padding: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: white;
        font-size: 0.9rem;
        min-height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .calendar-day-cell:hover:not(.other-month):not(.past) {
        border-color: #0d6efd;
        box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.15);
        transform: translateY(-2px);
    }

    .calendar-day-cell.other-month {
        background: #f9f9f9;
        color: #ccc;
        cursor: not-allowed;
    }

    .calendar-day-cell.past {
        background: #f5f5f5;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .calendar-day-cell.available {
        border-color: #28a745;
        background: rgba(40, 167, 69, 0.05);
    }

    .calendar-day-cell.available.selected {
        background: #28a745;
        color: white;
        border-color: #28a745;
    }

    .calendar-day-cell.request {
        border-color: #ffc107;
        background: rgba(255, 193, 7, 0.05);
    }

    .calendar-day-cell.request.selected {
        background: #ffc107;
        color: white;
        border-color: #ffc107;
    }

    .date-legend {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding: 12px;
        background: #f9f9f9;
        border-radius: 8px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
    }

    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        border: 2px solid;
    }

    .legend-color.available {
        background: rgba(40, 167, 69, 0.1);
        border-color: #28a745;
    }

    .legend-color.request {
        background: rgba(255, 193, 7, 0.1);
        border-color: #ffc107;
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

    .status-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 575.98px) {
        .appointment-hero-actions .btn { width: 100%; }
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

            let classes = 'calendar-day-cell';
            if (!isCurrentMonth) classes += ' other-month';
            if (isPast && isCurrentMonth) classes += ' past';
            if (isAvailable && isCurrentMonth) classes += ' available';
            if (!isAvailable && isCurrentMonth && !isPast) classes += ' request';

            calendarDays += `<div class="${classes}" data-date="${dateStr}" data-day="${dayNumber}">
                ${dayNumber}
            </div>`;
            
            date.setDate(date.getDate() + 1);
        }

        document.getElementById('calendar-days').innerHTML = calendarDays;

        // Ajouter les event listeners
        document.querySelectorAll('.calendar-day-cell:not(.other-month):not(.past)').forEach(cell => {
            cell.addEventListener('click', selectDate);
        });
    }

    function selectDate(e) {
        const date = e.target.dataset.date;
        const isAvailable = e.target.classList.contains('available');
        
        document.querySelectorAll('.calendar-day-cell').forEach(cell => {
            cell.classList.remove('selected');
        });
        
        e.target.classList.add('selected');
        
        document.getElementById('appointment_date').value = date;
        document.getElementById('appointment_type').value = isAvailable ? 'available_day' : 'request_day';
        document.getElementById('selected-date-display').textContent = 
            new Date(date + 'T00:00:00').toLocaleDateString('fr-FR', 
                {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'});
        
        document.getElementById('selected-date-info').classList.remove('d-none');
        document.getElementById('appointment-submit').disabled = false;

        if (!isAvailable) {
            const alert = document.createElement('div');
            alert.className = 'alert alert-warning mt-2';
            alert.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Cette date nécessitera une approbation de l\'administrateur.';
            
            const existingAlert = document.getElementById('selected-date-info').querySelector('.alert-warning');
            if (existingAlert) existingAlert.remove();
            
            document.getElementById('selected-date-info').appendChild(alert);
        } else {
            const existingAlert = document.getElementById('selected-date-info').querySelector('.alert-warning');
            if (existingAlert) existingAlert.remove();
        }
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
