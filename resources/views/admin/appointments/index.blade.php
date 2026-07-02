<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="admin-kicker">Relation</p>
                <h1 class="mt-1 text-3xl font-semibold text-white">Rendez-vous demandés</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-200">Suivez les demandes, confirmez les horaires et gardez un historique propre des échanges.</p>
            </div>
            <a href="{{ route('admin.availability-slots.index') }}" class="rounded-xl bg-white px-4 py-2 text-sm font-black text-slate-950 shadow-sm transition hover:bg-amber-100">Gérer les créneaux</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
        @endif

        <section class="admin-card overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 p-5">
                <h2 class="text-lg font-semibold text-slate-950">Demandes reçues</h2>
                <p class="text-sm text-slate-500">Ouvrez une demande pour changer son statut, affecter un créneau ou répondre par email.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-black uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Demandeur</th>
                            <th class="px-5 py-3">Créneau</th>
                            <th class="px-5 py-3">Sujet</th>
                            <th class="px-5 py-3">Statut</th>
                            <th class="px-5 py-3">Demandé le</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($appointments as $appointment)
                            <tr class="align-top">
                                <td class="px-5 py-4">
                                    <p class="font-bold text-slate-900">{{ $appointment->name }}</p>
                                    <a href="mailto:{{ $appointment->email }}" class="mt-1 block text-xs font-semibold text-teal-700 hover:text-teal-900">{{ $appointment->email }}</a>
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    @if ($appointment->availabilitySlot?->slot_type === 'request')
                                        <p class="font-semibold">{{ $appointment->appointment_date?->format('d/m/Y') }}</p>
                                        <p class="mt-1 text-xs text-amber-700">Date proposee par le visiteur</p>
                                    @elseif ($appointment->availabilitySlot)
                                        <p class="font-semibold">{{ $appointment->availabilitySlot->start_time->format('d/m/Y H:i') }}</p>
                                        <p class="mt-1 text-xs text-slate-500">Fin à {{ $appointment->availabilitySlot->end_time->format('H:i') }}</p>
                                    @elseif ($appointment->appointment_date)
                                        <p class="font-semibold">{{ $appointment->appointment_date->format('d/m/Y') }}</p>
                                        <p class="mt-1 text-xs text-amber-700">Date proposee</p>
                                    @else
                                        <span class="text-slate-400">Non attribué</span>
                                    @endif
                                </td>
                                <td class="max-w-xs px-5 py-4 text-slate-600">{{ Str::limit($appointment->subject, 70) }}</td>
                                <td class="px-5 py-4">
                                    @switch($appointment->status)
                                        @case('confirmed')
                                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-700">Confirmé</span>
                                            @break
                                        @case('cancelled')
                                            <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-black text-rose-700">Annulé</span>
                                            @break
                                        @case('completed')
                                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-700">Terminé</span>
                                            @break
                                        @default
                                            <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-black text-amber-700">En attente</span>
                                    @endswitch
                                </td>
                                <td class="px-5 py-4 text-slate-600">{{ $appointment->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.appointments.show', $appointment) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-black text-slate-700 hover:border-teal-400 hover:text-teal-700">Traiter</a>
                                        <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-black text-rose-700 hover:bg-rose-50" onclick="return confirm('Supprimer ce rendez-vous ?')">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-sm text-slate-500">Aucune demande de rendez-vous pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div>{{ $appointments->links() }}</div>
    </div>
</x-app-layout>
