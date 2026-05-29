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
</x-app-layout>
