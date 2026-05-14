<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-teal-600">Medias & portfolio</p>
                <h1 class="text-2xl font-semibold text-slate-950">Bibliotheque publique</h1>
                <p class="mt-1 text-sm text-slate-500">Publiez photos, videos, interventions et projets.</p>
            </div>
            <a href="{{ route('admin.portfolios.create') }}" class="rounded-lg bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-teal-700">Nouveau media</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
        @endif

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse($projects as $project)
                <article class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                    @if(!empty($project->images[0]))
                        <img class="aspect-video w-full object-cover" src="{{ asset('storage/'.$project->images[0]) }}" alt="{{ $project->title }}">
                    @else
                        <div class="grid aspect-video place-items-center bg-slate-100 text-sm font-semibold text-slate-400">Aucune image</div>
                    @endif
                    <div class="space-y-4 p-5">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ ucfirst($project->category?->type ?? 'general') }}</span>
                                @if($project->video_url)
                                    <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-700">Video</span>
                                @endif
                            </div>
                            <h2 class="mt-3 text-lg font-semibold text-slate-950">{{ $project->title }}</h2>
                            <p class="mt-2 line-clamp-2 text-sm text-slate-500">{{ $project->description }}</p>
                        </div>
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                            <span>{{ $project->views }} vues</span>
                            <span>{{ $project->likes }} likes</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <a class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-center text-sm font-semibold text-slate-700 transition hover:border-teal-400 hover:text-teal-700" href="{{ route('admin.portfolios.edit', $project) }}">Editer</a>
                            <form method="POST" action="{{ route('admin.portfolios.destroy', $project) }}" onsubmit="return confirm('Supprimer cet element ?')">
                                @csrf @method('DELETE')
                                <button class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500 md:col-span-2 xl:col-span-3">Aucun media ou projet pour le moment.</div>
            @endforelse
        </div>

        {{ $projects->links() }}
    </div>
</x-app-layout>
