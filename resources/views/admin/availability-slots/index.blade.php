<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="admin-kicker">Planning</p>
                <h1 class="mt-1 text-3xl font-semibold text-white">Créneaux de disponibilité</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-200">Gérez les dates ouvertes aux rendez-vous, les capacités et les créneaux déjà remplis.</p>
            </div>
            <a href="{{ route('admin.availability-slots.create') }}" class="rounded-xl bg-white px-4 py-2 text-sm font-black text-slate-950 shadow-sm transition hover:bg-amber-100">Ajouter un créneau</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
        @endif

        <section class="grid gap-6 lg:grid-cols-[minmax(340px,520px)_1fr]">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-4 border-b border-slate-100 bg-slate-50/70 p-4">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-teal-700">Calendrier</p>
                        <h2 class="mt-1 text-xl font-black text-slate-950">{{ ucfirst($currentDate->locale('fr')->monthName) }} {{ $currentDate->year }}</h2>
                        <p class="mt-1 text-sm text-slate-500">Activez ou retirez les jours ouverts aux rendez-vous.</p>
                    </div>
                    <div class="grid grid-cols-[2.25rem_1fr_2.25rem] items-center gap-2 rounded-xl border border-slate-200 bg-white p-1">
                        <a href="{{ route('admin.availability-slots.index', ['year' => $currentDate->copy()->subMonth()->year, 'month' => $currentDate->copy()->subMonth()->month]) }}" class="grid h-9 w-9 place-items-center rounded-lg border border-slate-200 bg-white text-slate-700 transition hover:border-teal-300 hover:text-teal-700" aria-label="Mois precedent">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <a href="{{ route('admin.availability-slots.index', ['year' => now()->year, 'month' => now()->month]) }}" class="text-center text-xs font-black uppercase tracking-wide text-slate-500 transition hover:text-teal-700">Aujourd'hui</a>
                        <a href="{{ route('admin.availability-slots.index', ['year' => $currentDate->copy()->addMonth()->year, 'month' => $currentDate->copy()->addMonth()->month]) }}" class="grid h-9 w-9 place-items-center rounded-lg border border-slate-200 bg-white text-slate-700 transition hover:border-teal-300 hover:text-teal-700" aria-label="Mois suivant">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>

                <div class="admin-month-calendar">
                    <div class="admin-weekdays">
                        <span>Lun</span>
                        <span>Mar</span>
                        <span>Mer</span>
                        <span>Jeu</span>
                        <span>Ven</span>
                        <span>Sam</span>
                        <span>Dim</span>
                    </div>

                    <div class="admin-month-grid">
                        @php
                            $firstDay = $currentDate->copy()->startOfMonth();
                            $previousDays = $firstDay->dayOfWeek === 0 ? 6 : $firstDay->dayOfWeek - 1;
                            $startDate = $firstDay->copy()->subDays($previousDays);
                        @endphp

                        @for ($i = 0; $i < 42; $i++)
                            @php
                                $date = $startDate->copy()->addDays($i);
                                $dateKey = $date->format('Y-m-d');
                                $isCurrentMonth = $date->month === $currentDate->month;
                                $isPast = $date->lt(now()->startOfDay());
                                $isAvailable = $isCurrentMonth && in_array($date->day, $availableDays);
                                $hasPending = in_array($dateKey, $pendingRequests);
                                $dayMeta = $availabilityMap[$dateKey] ?? null;
                            @endphp

                            <form action="{{ route('admin.availability-slots.toggle-day') }}" method="POST" class="admin-day {{ ! $isCurrentMonth ? 'is-muted' : '' }} {{ $isPast ? 'is-past' : '' }} {{ $isAvailable ? 'is-available' : '' }} {{ $hasPending ? 'has-pending' : '' }}">
                                @csrf
                                <input type="hidden" name="date" value="{{ $dateKey }}">
                                <button type="submit" @disabled(! $isCurrentMonth || $isPast) title="{{ $isAvailable ? 'Retirer la disponibilite' : 'Rendre disponible' }}">
                                    <span class="admin-day-number">{{ $date->day }}</span>
                                    <span class="admin-day-markers">
                                        @if ($isAvailable)
                                            <span class="marker availability {{ ($dayMeta['full'] ?? false) ? 'is-full' : '' }}"></span>
                                        @endif
                                        @if ($hasPending)
                                            <span class="marker pending"></span>
                                        @endif
                                    </span>
                                    @if ($dayMeta)
                                        <span class="admin-day-caption">{{ $dayMeta['remaining'] }}/{{ $dayMeta['capacity'] }} dispo.</span>
                                    @elseif ($hasPending)
                                        <span class="admin-day-caption">demande</span>
                                    @endif
                                </button>
                            </form>
                        @endfor
                    </div>

                    <div class="admin-calendar-legend">
                        <span><i class="marker availability"></i> Jour disponible</span>
                        <span><i class="marker pending"></i> Demande a valider</span>
                        <span><i class="marker availability is-full"></i> Complet</span>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-4 border-b border-slate-100 bg-slate-50/70 p-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-teal-700">Vue annuelle</p>
                        <h2 class="mt-1 text-xl font-black text-slate-950">{{ $year }}</h2>
                        <p class="mt-1 text-sm text-slate-500">Acces direct aux mois et lecture rapide des disponibilites.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.availability-slots.index', ['year' => $year - 1, 'month' => $month]) }}" class="grid h-9 w-9 place-items-center rounded-lg border border-slate-200 bg-white text-slate-700 transition hover:border-teal-300 hover:text-teal-700" aria-label="Annee precedente">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <a href="{{ route('admin.availability-slots.index', ['year' => now()->year, 'month' => now()->month]) }}" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-black uppercase tracking-wide text-slate-500 transition hover:border-teal-300 hover:text-teal-700">Cette annee</a>
                        <a href="{{ route('admin.availability-slots.index', ['year' => $year + 1, 'month' => $month]) }}" class="grid h-9 w-9 place-items-center rounded-lg border border-slate-200 bg-white text-slate-700 transition hover:border-teal-300 hover:text-teal-700" aria-label="Annee suivante">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>

                <div class="admin-year-overview">
                    @foreach ($yearMonths as $yearMonth)
                        @php
                            $availabilityPercent = $yearMonth['capacity'] > 0
                                ? min(100, round(($yearMonth['remaining'] / $yearMonth['capacity']) * 100))
                                : 0;
                        @endphp
                        <a href="{{ route('admin.availability-slots.index', ['year' => $year, 'month' => $yearMonth['number']]) }}" class="admin-year-month {{ $yearMonth['is_selected'] ? 'is-selected' : '' }} {{ $yearMonth['is_current'] ? 'is-current' : '' }}">
                            <span class="flex items-start justify-between gap-3">
                                <span>
                                    <span class="block text-sm font-black text-slate-950">{{ ucfirst($yearMonth['date']->locale('fr')->translatedFormat('M')) }}</span>
                                    <span class="mt-1 block text-xs font-bold text-slate-500">{{ $yearMonth['available_days'] }} jour(s) ouvert(s)</span>
                                </span>
                                @if ($yearMonth['pending'] > 0)
                                    <span class="rounded-full bg-orange-50 px-2 py-1 text-[0.65rem] font-black text-orange-700">{{ $yearMonth['pending'] }}</span>
                                @endif
                            </span>
                            <span class="mt-4 block h-1.5 overflow-hidden rounded-full bg-slate-100">
                                <span class="block h-full rounded-full {{ $yearMonth['remaining'] > 0 ? 'bg-teal-500' : 'bg-slate-300' }}" style="width: {{ $yearMonth['capacity'] > 0 ? max(12, $availabilityPercent) : 0 }}%"></span>
                            </span>
                            <span class="mt-2 flex justify-between text-[0.68rem] font-black uppercase tracking-wide text-slate-500">
                                <span>{{ $yearMonth['remaining'] }}/{{ $yearMonth['capacity'] }} places</span>
                                @if ($yearMonth['is_current'])
                                    <span>Aujourd'hui</span>
                                @endif
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="admin-card overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 p-5">
                <h2 class="text-lg font-semibold text-slate-950">Tous les créneaux</h2>
                <p class="text-sm text-slate-500">Les visiteurs ne voient que les créneaux disponibles avec des places restantes.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-black uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Date</th>
                            <th class="px-5 py-3">Durée</th>
                            <th class="px-5 py-3">Occupation</th>
                            <th class="px-5 py-3">Statut</th>
                            <th class="px-5 py-3">Description</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($slots as $slot)
                            @php
                                $remaining = max($slot->max_appointments - $slot->current_appointments, 0);
                                $percent = $slot->max_appointments > 0 ? min(100, round(($slot->current_appointments / $slot->max_appointments) * 100)) : 0;
                            @endphp
                            <tr class="align-top">
                                <td class="px-5 py-4">
                                    <p class="font-bold text-slate-900">{{ $slot->start_time->format('d/m/Y H:i') }}</p>
                                    <p class="mt-1 text-xs text-slate-500">Fin à {{ $slot->end_time->format('H:i') }}</p>
                                </td>
                                <td class="px-5 py-4 text-slate-700">{{ $slot->start_time->diff($slot->end_time)->format('%H:%I') }} h</td>
                                <td class="px-5 py-4">
                                    <div class="min-w-36">
                                        <div class="flex justify-between text-xs font-bold text-slate-500">
                                            <span>{{ $slot->current_appointments }}/{{ $slot->max_appointments }}</span>
                                            <span>{{ $remaining }} place(s)</span>
                                        </div>
                                        <div class="mt-2 h-2 rounded-full bg-slate-100">
                                            <div class="h-2 rounded-full {{ $remaining > 0 ? 'bg-emerald-500' : 'bg-rose-500' }}" style="width: {{ $percent }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    @if (! $slot->is_available)
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-600">Indisponible</span>
                                    @elseif ($remaining === 0)
                                        <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-black text-rose-700">Complet</span>
                                    @else
                                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-700">Disponible</span>
                                    @endif
                                </td>
                                <td class="max-w-xs px-5 py-4 text-slate-600">{{ Str::limit($slot->description ?: 'Aucune description', 70) }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.availability-slots.edit', $slot) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-black text-slate-700 hover:border-teal-400 hover:text-teal-700">Modifier</a>
                                        <form action="{{ route('admin.availability-slots.destroy', $slot) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-black text-rose-700 hover:bg-rose-50" onclick="return confirm('Supprimer ce créneau ?')">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-sm text-slate-500">Aucun créneau de disponibilité pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div>{{ $slots->links() }}</div>
    </div>

    <style>
        .admin-month-calendar { padding: .65rem; }
        .admin-weekdays,
        .admin-month-grid { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); }
        .admin-weekdays span {
            color: #64748b;
            font-size: .58rem;
            font-weight: 900;
            padding: .15rem 0 .35rem;
            text-align: center;
            text-transform: uppercase;
        }
        .admin-month-grid {
            background: transparent;
            border: 0;
            gap: .25rem;
        }
        .admin-day { min-width: 0; }
        .admin-day button {
            align-items: flex-start;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            color: #020617;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            gap: .55rem;
            justify-content: center;
            min-height: clamp(3rem, 6.5vw, 3.85rem);
            padding: .28rem .12rem;
            text-align: center;
            transition: background .18s ease, box-shadow .18s ease;
            width: 100%;
        }
        .admin-day:not(.is-muted):not(.is-past) button:hover {
            background: #f0fdfa;
            box-shadow: inset 0 0 0 2px rgba(20, 184, 166, .28);
        }
        .admin-day button:disabled { cursor: not-allowed; }
        .admin-day-number {
            align-items: center;
            border-radius: 10px;
            display: inline-flex;
            font-size: clamp(.82rem, 2.55vw, 1.05rem);
            font-weight: 900;
            height: 1.55rem;
            justify-content: center;
            letter-spacing: 0;
            line-height: 1;
            min-width: 1.55rem;
        }
        .admin-day.is-muted button,
        .admin-day.is-past button { background: #f8fafc; color: #94a3b8; }
        .admin-day.is-muted .admin-day-number,
        .admin-day.is-past .admin-day-number { color: #9ca3af; }
        .admin-day.is-available .admin-day-number { background: #ccfbf1; color: #0f766e; }
        .admin-day.has-pending .admin-day-number { background: #fff7ed; color: #c2410c; }
        .admin-day-markers { align-items: center; display: flex; gap: .25rem; justify-content: center; min-height: .45rem; }
        .marker { border-radius: 999px; display: inline-block; height: .38rem; width: .38rem; }
        .marker.availability { background: #14b8a6; }
        .marker.pending { background: #f97316; width: .9rem; }
        .marker.is-full { background: #64748b; }
        .admin-day-caption { color: #64748b; font-size: .5rem; font-weight: 900; line-height: 1; }
        .admin-calendar-legend { display: flex; flex-wrap: wrap; gap: .55rem; padding-top: .7rem; }
        .admin-calendar-legend span {
            align-items: center;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            color: #475569;
            display: inline-flex;
            font-size: .68rem;
            font-weight: 800;
            gap: .45rem;
            padding: .35rem .55rem;
        }
        .admin-year-overview {
            display: grid;
            gap: .75rem;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            padding: 1rem;
        }
        .admin-year-month {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            display: block;
            min-height: 6.9rem;
            padding: .9rem;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }
        .admin-year-month:hover {
            border-color: #5eead4;
            box-shadow: 0 12px 24px rgba(15, 23, 42, .08);
            transform: translateY(-1px);
        }
        .admin-year-month.is-selected {
            background: #f0fdfa;
            border-color: #14b8a6;
            box-shadow: inset 0 0 0 1px rgba(20, 184, 166, .18);
        }
        .admin-year-month.is-current:not(.is-selected) {
            border-color: #fed7aa;
        }

        @media (max-width: 640px) {
            .admin-day button {
                min-height: 3.7rem;
            }

            .admin-day-caption {
                display: none;
            }
        }

        @media (min-width: 1280px) {
            .admin-year-overview {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }
    </style>
</x-app-layout>
