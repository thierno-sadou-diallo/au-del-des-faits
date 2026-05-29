<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="admin-kicker">Planning</p>
            <h1 class="mt-1 text-3xl font-semibold text-white">Ajouter un créneau</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-200">Ouvrez une disponibilité claire pour recevoir les demandes de rendez-vous.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                <p class="font-bold">Merci de corriger les champs signalés.</p>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.availability-slots.store') }}" class="grid gap-6 lg:grid-cols-[1fr_320px]">
            @csrf

            <section class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="start_time" class="mb-2 block text-sm font-semibold text-slate-700">Date et heure de début</label>
                        <input id="start_time" name="start_time" type="datetime-local" required value="{{ old('start_time') }}" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                        @error('start_time')<p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="end_time" class="mb-2 block text-sm font-semibold text-slate-700">Date et heure de fin</label>
                        <input id="end_time" name="end_time" type="datetime-local" required value="{{ old('end_time') }}" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                        @error('end_time')<p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-5">
                    <label for="max_appointments" class="mb-2 block text-sm font-semibold text-slate-700">Nombre maximum de rendez-vous</label>
                    <input id="max_appointments" name="max_appointments" type="number" min="1" required value="{{ old('max_appointments', 1) }}" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                    @error('max_appointments')<p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                </div>

                <div class="mt-5">
                    <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
                    <textarea id="description" name="description" rows="4" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Ex: consultation en ligne, échange éditorial, accompagnement projet...">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                </div>

                <label class="mt-5 flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_available" value="1" checked class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    Créneau visible et disponible
                </label>
            </section>

            <aside class="space-y-4">
                <div class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-sm font-black uppercase tracking-[0.18em] text-slate-500">Publication</h2>
                    <div class="mt-5 grid gap-3">
                        <button class="rounded-xl bg-slate-950 px-4 py-3 text-sm font-black text-white hover:bg-teal-700">Créer le créneau</button>
                        <a href="{{ route('admin.availability-slots.index') }}" class="rounded-xl border border-slate-200 px-4 py-3 text-center text-sm font-black text-slate-700 hover:border-teal-400 hover:text-teal-700">Annuler</a>
                    </div>
                </div>
                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 text-sm text-amber-900">
                    <p class="font-black">Conseil</p>
                    <p class="mt-2 leading-6">Prévoyez des durées réalistes et une description compréhensible pour que les visiteurs choisissent le bon rendez-vous.</p>
                </div>
            </aside>
        </form>
    </div>
</x-app-layout>
