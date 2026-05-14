<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-teal-600">Bibliotheque</p>
                <h1 class="text-2xl font-semibold text-slate-950">Categories</h1>
                <p class="mt-1 text-sm text-slate-500">Organisez les articles, les projets et les medias publics.</p>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.categories.store') }}" class="grid gap-3 rounded-lg border border-slate-200 bg-white p-4 shadow-sm md:grid-cols-[1fr_220px_auto]">
            @csrf
            <input class="rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="name" placeholder="Nom de la categorie" required>
            <select class="rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="type">
                <option value="blog">Blog</option>
                <option value="portfolio">Portfolio</option>
                <option value="media">Media</option>
            </select>
            <button class="rounded-lg bg-slate-950 px-5 py-2 text-sm font-semibold text-white transition hover:bg-teal-700">Ajouter</button>
        </form>

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            @foreach($categories as $category)
                <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="grid gap-3 border-b border-slate-100 p-4 last:border-b-0 md:grid-cols-[1fr_220px_auto]">
                    @csrf @method('PATCH')
                    <input class="rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="name" value="{{ $category->name }}" required>
                    <select class="rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="type">
                        <option value="blog" @selected($category->type === 'blog')>Blog</option>
                        <option value="portfolio" @selected($category->type === 'portfolio')>Portfolio</option>
                        <option value="media" @selected($category->type === 'media')>Media</option>
                    </select>
                    <button class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-teal-500 hover:text-teal-700">Mettre a jour</button>
                </form>
            @endforeach
        </div>

        {{ $categories->links() }}
    </div>
</x-app-layout>
