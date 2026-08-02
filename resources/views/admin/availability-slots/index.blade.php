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

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 border-b border-slate-100 p-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-rose-500">Calendrier</p>
                    <h2 class="mt-1 text-3xl font-black text-slate-950">{{ ucfirst($currentDate->locale('fr')->monthName) }}</h2>
                    <p class="mt-1 text-sm text-slate-500">Cliquez sur une date future pour ouvrir ou fermer la journee aux rendez-vous.</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.availability-slots.index', ['year' => $currentDate->copy()->subMonth()->year, 'month' => $currentDate->copy()->subMonth()->month]) }}" class="grid h-10 w-10 place-items-center rounded-full border border-slate-200 text-slate-700 transition hover:border-rose-300 hover:text-rose-600" aria-label="Mois precedent">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <span class="min-w-28 text-center text-sm font-black text-slate-600">{{ $currentDate->year }}</span>
                    <a href="{{ route('admin.availability-slots.index', ['year' => $currentDate->copy()->addMonth()->year, 'month' => $currentDate->copy()->addMonth()->month]) }}" class="grid h-10 w-10 place-items-center rounded-full border border-slate-200 text-slate-700 transition hover:border-rose-300 hover:text-rose-600" aria-label="Mois suivant">
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
                                    <span class="admin-day-caption">{{ $dayMeta['remaining'] }} place{{ $dayMeta['remaining'] > 1 ? 's' : '' }}</span>
                                @elseif ($hasPending)
                                    <span class="admin-day-caption">demande</span>
                                @endif
                            </button>
                        </form>
                    @endfor
                </div>

                <div class="admin-calendar-legend">
                    <span><i class="marker availability"></i> Disponible</span>
                    <span><i class="marker pending"></i> Demande visiteur</span>
                    <span><i class="marker availability is-full"></i> Complet</span>
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
        .admin-month-calendar {
            padding: clamp(1rem, 2.4vw, 1.75rem);
        }

        .admin-weekdays,
        .admin-month-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
        }

        .admin-weekdays span {
            color: #94a3b8;
            font-size: .72rem;
            font-weight: 900;
            padding: .25rem .35rem .75rem;
            text-align: center;
            text-transform: uppercase;
        }

        .admin-month-grid {
            border-top: 1px solid #e5e7eb;
        }

        .admin-day {
            min-width: 0;
        }

        .admin-day button {
            align-items: center;
            background: #fff;
            border: 0;
            border-bottom: 1px solid #e5e7eb;
            color: #020617;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            gap: .55rem;
            min-height: clamp(5.5rem, 10vw, 8.25rem);
            padding: clamp(.6rem, 1.5vw, 1.25rem) .35rem;
            width: 100%;
        }

        .admin-day button:disabled {
            cursor: not-allowed;
        }

        .admin-day-number {
            font-size: clamp(1.8rem, 4.4vw, 3.9rem);
            font-weight: 950;
            letter-spacing: 0;
            line-height: 1;
        }

        .admin-day.is-muted .admin-day-number,
        .admin-day.is-past .admin-day-number {
            color: #9ca3af;
        }

        .admin-day.is-available .admin-day-number {
            color: #020617;
        }

        .admin-day.has-pending .admin-day-number {
            color: #ef4444;
        }

        .admin-day-markers {
            align-items: center;
            display: flex;
            gap: .18rem;
            min-height: .75rem;
        }

        .marker {
            border-radius: 999px;
            display: inline-block;
            height: .62rem;
            width: .62rem;
        }

        .marker.availability {
            background: #e9a4f0;
        }

        .marker.pending {
            background: #fdc46f;
            width: 1.6rem;
        }

        .marker.is-full {
            background: #94a3b8;
        }

        .admin-day-caption {
            color: #64748b;
            font-size: .68rem;
            font-weight: 900;
            line-height: 1;
        }

        .admin-calendar-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            padding-top: 1rem;
        }

        .admin-calendar-legend span {
            align-items: center;
            color: #475569;
            display: inline-flex;
            font-size: .78rem;
            font-weight: 800;
            gap: .45rem;
        }

        @media (max-width: 640px) {
            .admin-day button {
                min-height: 4.6rem;
            }

            .admin-day-caption {
                display: none;
            }
        }
    </style>
</x-app-layout>
