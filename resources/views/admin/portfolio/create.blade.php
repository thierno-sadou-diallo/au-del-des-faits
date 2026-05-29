<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="admin-kicker">Médias</p>
                <h1 class="mt-1 text-3xl font-semibold text-white">Publier un média</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-200">Ajoutez des images accompagnées d’un texte, d’une catégorie et, si besoin, d’un lien vidéo ou externe.</p>
            </div>
            <a href="{{ route('admin.portfolios.index') }}" class="rounded-xl border border-white/20 bg-white/10 px-4 py-2 text-sm font-black text-white transition hover:bg-white/15">Retour aux médias</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('admin.portfolios.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @include('admin.portfolio.partials.form')
        </form>
    </div>
</x-app-layout>
