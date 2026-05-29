<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="admin-kicker">Rendez-vous</p>
                <h1 class="mt-1 text-3xl font-semibold text-white">Détails de la demande</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-200">{{ $appointment->subject }}</p>
            </div>
            <a href="{{ route('admin.appointments.index') }}" class="rounded-xl border border-white/20 bg-white/10 px-4 py-2 text-sm font-black text-white transition hover:bg-white/15">Retour à la liste</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">{{ session('error') }}</div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
            <div class="space-y-6">
                <section class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-950">Informations du demandeur</h2>
                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-black uppercase tracking-wider text-slate-400">Nom</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $appointment->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-black uppercase tracking-wider text-slate-400">Email</p>
                            <a href="mailto:{{ $appointment->email }}" class="mt-1 block font-semibold text-teal-700 hover:text-teal-900">{{ $appointment->email }}</a>
                        </div>
                        @if ($appointment->phone)
                            <div>
                                <p class="text-xs font-black uppercase tracking-wider text-slate-400">Téléphone</p>
                                <a href="tel:{{ $appointment->phone }}" class="mt-1 block font-semibold text-teal-700 hover:text-teal-900">{{ $appointment->phone }}</a>
                            </div>
                        @endif
                        @if ($appointment->organization)
                            <div>
                                <p class="text-xs font-black uppercase tracking-wider text-slate-400">Organisation</p>
                                <p class="mt-1 font-semibold text-slate-900">{{ $appointment->organization }}</p>
                            </div>
                        @endif
                    </div>
                </section>

                <section class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-950">Contenu de la demande</h2>
                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-black uppercase tracking-wider text-slate-400">Créneau</p>
                            @if ($appointment->availabilitySlot)
                                <p class="mt-1 font-semibold text-slate-900">{{ $appointment->availabilitySlot->start_time->format('d/m/Y H:i') }} à {{ $appointment->availabilitySlot->end_time->format('H:i') }}</p>
                            @else
                                <p class="mt-1 text-slate-500">Non attribué</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-black uppercase tracking-wider text-slate-400">Demandé le</p>
                            <p class="mt-1 font-semibold text-slate-900">{{ $appointment->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="mt-5">
                        <p class="text-xs font-black uppercase tracking-wider text-slate-400">Objet</p>
                        <p class="mt-1 font-semibold text-slate-900">{{ $appointment->subject }}</p>
                    </div>
                    <div class="mt-5 rounded-2xl border border-slate-100 bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                        {!! nl2br(e($appointment->message)) !!}
                    </div>
                </section>
            </div>

            <aside class="space-y-6">
                <section class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-950">Statut</h2>
                    <form method="POST" action="{{ route('admin.appointments.updateStatus', $appointment) }}" class="mt-5 space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Statut du rendez-vous</label>
                            <select id="status" name="status" required class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                                <option value="pending" @selected($appointment->status === 'pending')>En attente</option>
                                <option value="confirmed" @selected($appointment->status === 'confirmed')>Confirmé</option>
                                <option value="completed" @selected($appointment->status === 'completed')>Terminé</option>
                                <option value="cancelled" @selected($appointment->status === 'cancelled')>Annulé</option>
                            </select>
                            @error('status')<p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="admin_notes" class="mb-2 block text-sm font-semibold text-slate-700">Notes internes</label>
                            <textarea id="admin_notes" name="admin_notes" rows="4" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Décisions, suivi, prochaine action...">{{ old('admin_notes', $appointment->admin_notes) }}</textarea>
                            @error('admin_notes')<p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                        </div>

                        <button class="w-full rounded-xl bg-slate-950 px-4 py-3 text-sm font-black text-white hover:bg-teal-700">Mettre à jour</button>
                    </form>
                </section>

                <section class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-950">Programmer un créneau</h2>
                    @error('availability_slot_id')<p class="mt-3 rounded-xl bg-rose-50 p-3 text-sm font-semibold text-rose-700">{{ $message }}</p>@enderror
                    <form method="POST" action="{{ route('admin.appointments.schedule', $appointment) }}" class="mt-5 space-y-4">
                        @csrf
                        @method('PATCH')

                        <select name="availability_slot_id" id="availability_slot_id" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                            <option value="">Sélectionner un créneau</option>
                            @foreach ($slots as $slot)
                                @php
                                    $isCurrent = $appointment->availability_slot_id === $slot->id;
                                    $isFull = $slot->current_appointments >= $slot->max_appointments;
                                @endphp
                                <option value="{{ $slot->id }}" @selected($isCurrent) @disabled($isFull && ! $isCurrent)>
                                    {{ $slot->start_time->format('d/m/Y H:i') }} - {{ $slot->end_time->format('H:i') }}
                                    @if($slot->description) - {{ $slot->description }} @endif
                                    ({{ max($slot->max_appointments - $slot->current_appointments, 0) }} place(s))
                                    @if ($isFull && ! $isCurrent) - complet @endif
                                </option>
                            @endforeach
                        </select>

                        <button class="w-full rounded-xl bg-emerald-700 px-4 py-3 text-sm font-black text-white hover:bg-emerald-800">Programmer la date</button>
                    </form>
                </section>

                <section class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-950">Actions</h2>
                    <div class="mt-5 grid gap-3">
                        <a href="mailto:{{ $appointment->email }}" class="rounded-xl border border-slate-200 px-4 py-3 text-center text-sm font-black text-slate-700 hover:border-teal-400 hover:text-teal-700">Envoyer un email</a>
                        <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full rounded-xl border border-rose-200 px-4 py-3 text-sm font-black text-rose-700 hover:bg-rose-50" onclick="return confirm('Supprimer ce rendez-vous ?')">Supprimer</button>
                        </form>
                    </div>
                </section>
            </aside>
        </div>
    </div>
</x-app-layout>
