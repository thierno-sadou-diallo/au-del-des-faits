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
                    <div class="calendar-month-toolbar">
                        <button class="calendar-nav-button" id="prev-month" type="button" aria-label="Mois precedent">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h3 id="month-display" class="calendar-month-title">{{ ucfirst($currentDate->locale('fr')->monthName) }}</h3>
                        <button class="calendar-nav-button" id="next-month" type="button" aria-label="Mois suivant">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <p id="year-display" class="calendar-year">{{ $currentDate->year }}</p>

                    <!-- Message si pas de dates disponibles -->
                    <div id="no-available-dates" class="alert alert-info alert-sm mb-3" style="display: none;">
                        <i class="fas fa-calendar-times me-2"></i>
                        <small>Aucune date disponible ce mois-ci. Vous pouvez proposer une date spécifique ci-dessous.</small>
                    </div>

                    <!-- Grille calendaire -->
                    <div class="calendar-grid-user mb-2">
                        <div class="calendar-day-header">L</div>
                        <div class="calendar-day-header">M</div>
                        <div class="calendar-day-header">M</div>
                        <div class="calendar-day-header">J</div>
                        <div class="calendar-day-header">V</div>
                        <div class="calendar-day-header">S</div>
                        <div class="calendar-day-header">D</div>

                        <div id="calendar-days"></div>
                    </div>

                    <!-- Légende simplifiée -->
                    <div class="date-legend">
                        <div class="legend-item">
                            <span class="legend-color available"></span>
                            <small>Disponible (approuvé automatiquement)</small>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color requested"></span>
                            <small>Date proposée (validation admin)</small>
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
                        <input type="hidden" id="availability_slot_id" name="availability_slot_id" value="">

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
                        <div class="col-md-9" id="appointment-captcha-wrapper">{!! captcha_img() !!}</div>
                        <div class="col-md-3 d-grid">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="refreshAppointmentCaptcha()">Rafraichir</button>
                        </div>
                        <div class="col-12">
                            <label for="appointment_captcha" class="form-label fw-bold" style="font-size: 0.9rem;">Captcha *</label>
                            <input type="text" class="form-control form-control-sm @error('captcha') is-invalid @enderror" id="appointment_captcha" name="captcha" required>
                            @error('captcha')<span class="invalid-feedback">{{ $message }}</span>@enderror
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

    .calendar-selector {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, .26);
        border-radius: 16px;
        box-shadow: 0 12px 34px rgba(15, 23, 42, .07);
        overflow: hidden;
        padding: .65rem;
    }

    .calendar-month-toolbar {
        align-items: center;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        display: grid;
        grid-template-columns: 2rem 1fr 2rem;
        gap: .5rem;
        padding: .35rem;
    }

    .calendar-month-title {
        color: #0f172a;
        font-size: clamp(.95rem, 2.5vw, 1.22rem);
        font-weight: 900;
        letter-spacing: 0;
        line-height: 1.1;
        margin: 0;
        text-align: center;
        text-transform: capitalize;
    }

    .calendar-year {
        color: #64748b;
        font-size: .64rem;
        font-weight: 900;
        margin: .3rem 0 .6rem;
        text-align: center;
    }

    .calendar-nav-button {
        align-items: center;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        color: #334155;
        display: inline-flex;
        height: 2rem;
        justify-content: center;
        transition: .18s ease;
        width: 2rem;
    }

    .calendar-nav-button:hover {
        border-color: #14b8a6;
        color: #0f766e;
    }

    .calendar-grid-user,
    #calendar-days {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
    }

    #calendar-days {
        display: contents;
    }

    .calendar-day-header {
        color: #64748b;
        font-size: .58rem;
        font-weight: 900;
        padding: .15rem 0 .35rem;
        text-align: center;
    }

    .calendar-day-cell {
        align-items: center;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        color: #020617;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        gap: .26rem;
        justify-content: center;
        min-height: clamp(3rem, 6.5vw, 3.85rem);
        padding: .28rem .12rem;
        text-align: center;
        transition: .18s ease;
    }

    .calendar-day-cell .day-number,
    .calendar-day-cell > span:first-child {
        align-items: center;
        border-radius: 8px;
        display: inline-flex;
        font-size: clamp(.82rem, 2.55vw, 1.05rem);
        font-weight: 900;
        height: 1.55rem;
        justify-content: center;
        letter-spacing: 0;
        line-height: 1;
        min-width: 1.55rem;
        padding: 0 .25rem;
    }

    .calendar-day-cell:hover:not(.other-month):not(.past):not(.unavailable) {
        background: #f0fdfa;
        border-color: #5eead4;
    }

    .calendar-day-cell.other-month,
    .calendar-day-cell.past,
    .calendar-day-cell.unavailable {
        background: #f8fafc;
        color: #9ca3af;
        cursor: not-allowed;
    }

    .calendar-day-cell.selected .day-number,
    .calendar-day-cell.selected > span:first-child {
        background: #0f766e;
        color: #fff;
    }

    .calendar-day-cell.selected {
        background: #ecfdf5;
        border-color: #0f766e;
        box-shadow: 0 10px 24px rgba(15, 118, 110, .18);
        color: #0f766e;
    }

    .calendar-day-cell.available::after,
    .calendar-day-cell.requested::after {
        border-radius: 999px;
        content: "";
        display: block;
        height: .38rem;
        order: 2;
    }

    .calendar-day-cell.available::after {
        background: #14b8a6;
        box-shadow: 0 0 0 3px rgba(20, 184, 166, .14);
        width: .38rem;
    }

    .calendar-day-cell.requested::after {
        background: #f97316;
        width: .9rem;
    }

    .calendar-markers {
        align-items: center;
        display: flex;
        gap: .14rem;
        min-height: .45rem;
    }

    .calendar-marker {
        background: #14b8a6;
        border-radius: 999px;
        display: inline-block;
        height: .38rem;
        width: .38rem;
    }

    .calendar-marker.request {
        background: #f97316;
        width: .9rem;
    }

    .calendar-day-cell.available .calendar-marker.available {
        box-shadow: 0 0 0 3px rgba(233, 164, 240, .18);
    }

    .calendar-day-cell small {
        color: #64748b;
        display: block;
        font-size: .5rem;
        font-weight: 900;
        line-height: 1;
        order: 3;
    }

    .date-legend {
        display: flex;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        gap: .55rem;
        margin-top: .6rem;
        padding: .5rem;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: .68rem;
        margin: 0;
    }

    .legend-color {
        width: 14px;
        height: 8px;
        border-radius: 999px;
        border: 0;
        flex-shrink: 0;
    }

    .legend-color.available {
        background: #14b8a6;
    }

    .legend-color.requested {
        background: #f97316;
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
        .calendar-selector { padding: .5rem; }
        .calendar-grid-user { gap: .25rem; }
        .calendar-day-cell { border-radius: 9px; min-height: 2.85rem; }
        .calendar-day-cell small { display: none; }
        .date-legend { flex-direction: column; gap: 6px; }
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentMonth = {{ $month }};
    let currentYear = {{ $year }};
    const availableDates = new Set(@json($availableDates));
    const availableSlotMap = @json($availableSlotMap);
    const hasAdminAvailableDates = @json($hasAdminAvailableDates);
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    function formatDate(date) {
        return date.getFullYear() + '-' +
            String(date.getMonth() + 1).padStart(2, '0') + '-' +
            String(date.getDate()).padStart(2, '0');
    }
    
    function generateCalendar() {
        const firstDay = new Date(currentYear, currentMonth - 1, 1);
        const lastDay = new Date(currentYear, currentMonth, 0);
        const daysInMonth = lastDay.getDate();
        const startingDayOfWeek = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1;

        const monthNames = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin',
                          'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
        document.getElementById('month-display').textContent = new Intl.DateTimeFormat('fr-FR', { month: 'long' })
            .format(new Date(currentYear, currentMonth - 1, 1));
        document.getElementById('year-display').textContent = currentYear;

        let calendarDays = '';
        let hasAvailableDates = false;
        let date = new Date(currentYear, currentMonth - 1, 1);
        date.setDate(date.getDate() - startingDayOfWeek);

        for (let i = 0; i < 42; i++) {
            const cellDate = new Date(date);
            cellDate.setHours(0, 0, 0, 0);
            const isCurrentMonth = date.getMonth() === currentMonth - 1;
            const isPast = cellDate < today;
            const dayNumber = date.getDate();
            const dateStr = formatDate(date);
            const isAvailable = isCurrentMonth && availableDates.has(dateStr);
            const canRequestDate = isCurrentMonth && !isPast && !isAvailable;
            const dateSlots = availableSlotMap[dateStr] || [];
            const firstSlot = dateSlots[0] || null;
            const remainingPlaces = dateSlots.reduce((total, slot) => total + slot.remaining, 0);

            if (isAvailable && isCurrentMonth) {
                hasAvailableDates = true;
            }

            let classes = 'calendar-day-cell';
            if (!isCurrentMonth) classes += ' other-month';
            if (isPast && isCurrentMonth) classes += ' past';
            if (isAvailable && isCurrentMonth) classes += ' available';
            if (canRequestDate && !isAvailable) classes += ' requested';
            if (!isAvailable && isCurrentMonth && !isPast && !canRequestDate) classes += ' unavailable';

            const appointmentType = isAvailable ? 'available_day' : (canRequestDate ? 'request_day' : '');

            calendarDays += `<div class="${classes}" data-date="${dateStr}" data-type="${appointmentType}" data-slot-id="${firstSlot ? firstSlot.id : ''}" data-remaining="${remainingPlaces}" data-day="${dayNumber}">
                <span class="day-number">${dayNumber}</span>
                ${isAvailable ? `<small>${remainingPlaces} place${remainingPlaces > 1 ? 's' : ''}</small>` : ''}
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
                requestOption.innerHTML = hasAdminAvailableDates
                    ? '<i class="fas fa-calendar-days me-2"></i>Consultez les autres mois pour une date admin, ou cliquez une date orange pour proposer un rendez-vous.'
                    : '<i class="fas fa-lightbulb me-2"></i><strong>Astuce:</strong> Cliquez sur une date future pour proposer un rendez-vous a approuver.';
                noAvailMsg.parentElement.insertBefore(requestOption, noAvailMsg.nextElementSibling);
            }
        } else {
            noAvailMsg.style.display = 'none';
            const requestOption = document.getElementById('request-date-option');
            if (requestOption) requestOption.remove();
        }

        // Ajouter les event listeners UNIQUEMENT aux dates disponibles
        document.querySelectorAll('.calendar-day-cell.available, .calendar-day-cell.requested').forEach(cell => {
            cell.addEventListener('click', selectDate);
        });
    }

    function selectDate(e) {
        const date = e.currentTarget.dataset.date;
        const appointmentType = e.currentTarget.dataset.type;
        const slotId = e.currentTarget.dataset.slotId || '';
        const remaining = e.currentTarget.dataset.remaining || '';
        
        document.querySelectorAll('.calendar-day-cell').forEach(cell => {
            cell.classList.remove('selected');
        });
        
        e.currentTarget.classList.add('selected');
        
        document.getElementById('appointment_date').value = date;
        document.getElementById('appointment_type').value = appointmentType;
        document.getElementById('availability_slot_id').value = slotId;
        document.getElementById('selected-date-display').textContent = 
            new Date(date + 'T00:00:00').toLocaleDateString('fr-FR', 
                {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}) +
            (appointmentType === 'request_day' ? ' - date a approuver' : ` - date active (${remaining} place${remaining === '1' ? '' : 's'} restante${remaining === '1' ? '' : 's'})`);
        
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

function refreshAppointmentCaptcha() {
    fetch('{{ route('captcha.refresh') }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('appointment-captcha-wrapper').innerHTML = data.captcha;
        });
}
</script>
@endpush

@endsection
