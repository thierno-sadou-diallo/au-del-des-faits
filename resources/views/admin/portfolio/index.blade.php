<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="admin-kicker">Médias</p>
                <h1 class="mt-1 text-3xl font-semibold text-white">Bibliothèque média</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-200">Publiez et gérez les images, textes associés, vidéos, interventions et contenus publics.</p>
            </div>
            <a href="{{ route('admin.portfolios.create') }}" class="rounded-xl bg-white px-4 py-2 text-sm font-black text-slate-950 shadow-sm transition hover:bg-amber-100">Nouveau média</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="admin-card rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm font-bold text-slate-500">Médias publiés</p>
                <p class="mt-3 text-3xl font-black text-slate-950">{{ $mediaTotal }}</p>
            </div>
            <div class="admin-card rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm font-bold text-slate-500">Vues cumulées</p>
                <p class="mt-3 text-3xl font-black text-slate-950">{{ number_format($mediaViews) }}</p>
            </div>
            <div class="admin-card rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm font-bold text-slate-500">Likes cumulés</p>
                <p class="mt-3 text-3xl font-black text-slate-950">{{ number_format($mediaLikes) }}</p>
            </div>
            <div class="admin-card rounded-2xl border border-amber-200 bg-amber-50 p-5">
                <p class="text-sm font-bold text-amber-800">Avec vidéo</p>
                <p class="mt-3 text-3xl font-black text-slate-950">{{ $mediaWithVideo }}</p>
            </div>
        </div>

        <section class="admin-card overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-950">Tous les médias</h2>
                    <p class="text-sm text-slate-500">Chaque élément peut contenir plusieurs images et un texte de description complet.</p>
                </div>
                <a href="{{ route('admin.portfolios.create') }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-black text-slate-700 hover:border-teal-400 hover:text-teal-700">Publier</a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($projects as $project)
                    <article class="grid gap-4 p-5 lg:grid-cols-[220px_1fr_auto] lg:items-center">
                        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-slate-50">
                            @if(!empty($project->images[0]))
                                <img class="aspect-video w-full object-cover" src="{{ asset('storage/'.$project->images[0]) }}" alt="{{ $project->title }}">
                            @else
                                <div class="grid aspect-video place-items-center text-sm font-semibold text-slate-400">Aucune image</div>
                            @endif
                        </div>

                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-600">{{ $project->category?->name ?? 'Sans catégorie' }}</span>
                                @if($project->category?->type)
                                    <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-black text-teal-700">{{ $project->category->type === 'media' ? 'Média' : 'Portfolio' }}</span>
                                @endif
                                @if($project->video_url)
                                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-700">Vidéo</span>
                                @endif
                                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-black text-amber-700">{{ count($project->images ?? []) }} image(s)</span>
                            </div>
                            <h2 class="mt-3 truncate text-lg font-semibold text-slate-950">{{ $project->title }}</h2>
                            <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">{{ $project->description }}</p>
                            <div class="mt-3 flex flex-wrap gap-4 text-xs font-semibold text-slate-500">
                                <span>{{ number_format($project->views) }} vues</span>
                                <span>{{ number_format($project->likes) }} likes</span>
                                <span>Mis à jour le {{ $project->updated_at->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        <div class="flex gap-2 lg:flex-col">
                            <a class="rounded-xl border border-slate-200 px-4 py-2 text-center text-sm font-black text-slate-700 transition hover:border-teal-400 hover:text-teal-700" href="{{ route('admin.portfolios.edit', $project) }}">Modifier</a>
                            <form method="POST" action="{{ route('admin.portfolios.destroy', $project) }}" onsubmit="return confirm('Supprimer ce média ?')">
                                @csrf
                                @method('DELETE')
                                <button class="w-full rounded-xl border border-rose-200 px-4 py-2 text-sm font-black text-rose-700 transition hover:bg-rose-50">Supprimer</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="p-10 text-center">
                        <p class="text-sm font-semibold text-slate-500">Aucun média pour le moment.</p>
                        <a href="{{ route('admin.portfolios.create') }}" class="mt-4 inline-flex rounded-xl bg-slate-950 px-4 py-2 text-sm font-black text-white hover:bg-teal-700">Publier le premier média</a>
                    </div>
                @endforelse
            </div>
        </section>

        {{ $projects->links() }}
    </div>
</x-app-layout>
