<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-teal-600">Publication</p>
                <h1 class="text-2xl font-semibold text-slate-950">Articles</h1>
                <p class="mt-1 text-sm text-slate-500">Redigez, publiez et optimisez le contenu du blog.</p>
            </div>
            <a href="{{ route('admin.posts.create') }}" class="rounded-lg bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-teal-700">Nouvel article</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
        @endif

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="grid grid-cols-[1fr_auto] gap-4 border-b border-slate-100 px-5 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-slate-400 md:grid-cols-[1.4fr_180px_140px_180px]">
                <span>Article</span>
                <span class="hidden md:block">Categorie</span>
                <span class="hidden md:block">Statut</span>
                <span class="text-right">Actions</span>
            </div>
            @forelse($posts as $post)
                <div class="grid grid-cols-[1fr_auto] gap-4 border-b border-slate-100 p-5 last:border-b-0 md:grid-cols-[1.4fr_180px_140px_180px] md:items-center">
                    <div>
                        <p class="font-semibold text-slate-950">{{ $post->title }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $post->views }} vues - {{ $post->likes }} likes</p>
                    </div>
                    <span class="hidden text-sm text-slate-600 md:block">{{ $post->category?->name ?? 'Sans categorie' }}</span>
                    <span class="hidden md:block">
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ $post->status === 'published' ? 'Publie' : 'Brouillon' }}</span>
                    </span>
                    <div class="flex items-center justify-end gap-2">
                        <a class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:border-teal-400 hover:text-teal-700" href="{{ route('admin.posts.edit', $post) }}">Editer</a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Supprimer cet article ?')">
                            @csrf @method('DELETE')
                            <button class="rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">Supprimer</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="p-6 text-sm text-slate-500">Aucun article. Creez votre premier contenu.</p>
            @endforelse
        </div>

        {{ $posts->links() }}
    </div>
</x-app-layout>
