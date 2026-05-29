<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="admin-kicker">Planning</p>
            <h1 class="mt-1 text-3xl font-semibold text-white">Modifier le créneau</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-200">Ajustez l’horaire, la capacité ou la visibilité du créneau.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                <p class="font-bold">Merci de corriger les champs signalés.</p>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.availability-slots.update', $slot) }}" class="grid gap-6 lg:grid-cols-[1fr_320px]">
            @csrf
            @method('PUT')

            <section class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="start_time" class="mb-2 block text-sm font-semibold text-slate-700">Date et heure de début</label>
                        <input id="start_time" name="start_time" type="datetime-local" required value="{{ old('start_time', $slot->start_time->format('Y-m-d\TH:i')) }}" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                        @error('start_time')<p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="end_time" class="mb-2 block text-sm font-semibold text-slate-700">Date et heure de fin</label>
                        <input id="end_time" name="end_time" type="datetime-local" required value="{{ old('end_time', $slot->end_time->format('Y-m-d\TH:i')) }}" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                        @error('end_time')<p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-5">
                    <label for="max_appointments" class="mb-2 block text-sm font-semibold text-slate-700">Nombre maximum de rendez-vous</label>
                    <input id="max_appointments" name="max_appointments" type="number" min="1" required value="{{ old('max_appointments', $slot->max_appointments) }}" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                    @error('max_appointments')<p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                </div>

                <div class="mt-5">
                    <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
                    <textarea id="description" name="description" rows="4" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">{{ old('description', $slot->description) }}</textarea>
                    @error('description')<p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                </div>

                <label class="mt-5 flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_available" value="1" @checked(old('is_available', $slot->is_available)) class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    Créneau visible et disponible
                </label>
            </section>

            <aside class="space-y-4">
                @php
                    $percent = $slot->max_appointments > 0 ? min(100, round(($slot->current_appointments / $slot->max_appointments) * 100)) : 0;
                @endphp
                <div class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-sm font-black uppercase tracking-[0.18em] text-slate-500">Occupation</h2>
                    <p class="mt-3 text-3xl font-black text-slate-950">{{ $slot->current_appointments }}/{{ $slot->max_appointments }}</p>
                    <div class="mt-4 h-3 rounded-full bg-slate-100">
                        <div class="h-3 rounded-full bg-teal-600" style="width: {{ $percent }}%"></div>
                    </div>
                    <p class="mt-4 text-xs text-slate-500">Créé le {{ $slot->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mt-1 text-xs text-slate-500">Mis à jour le {{ $slot->updated_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="grid gap-3">
                        <button class="rounded-xl bg-slate-950 px-4 py-3 text-sm font-black text-white hover:bg-teal-700">Mettre à jour</button>
                        <a href="{{ route('admin.availability-slots.index') }}" class="rounded-xl border border-slate-200 px-4 py-3 text-center text-sm font-black text-slate-700 hover:border-teal-400 hover:text-teal-700">Annuler</a>
                    </div>
                </div>
            </aside>
        </form>
    </div>
</x-app-layout>
