<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-teal-600">Pilotage</p>
                <h1 class="mt-1 text-3xl font-semibold text-slate-950">Tableau de bord administrateur</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-500">Publiez les articles, ajoutez des medias, suivez les performances et gardez les commentaires sous controle.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.posts.create') }}" class="rounded-lg bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-teal-700">Nouvel article</a>
                <a href="{{ route('admin.portfolios.create') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-teal-400 hover:text-teal-700">Nouveau media</a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                <p class="text-sm font-medium text-slate-500">Articles publies</p>
                <p class="mt-3 text-3xl font-semibold text-slate-950">{{ $publishedPostsCount }}</p>
                <p class="mt-1 text-xs text-slate-400">{{ $draftPostsCount }} brouillons sur {{ $postsCount }} articles</p>
            </div>
            <div class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                <p class="text-sm font-medium text-slate-500">Medias</p>
                <p class="mt-3 text-3xl font-semibold text-slate-950">{{ $mediaCount }}</p>
                <p class="mt-1 text-xs text-slate-400">{{ $projectsCount }} elements portfolio au total</p>
            </div>
            <div class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                <p class="text-sm font-medium text-slate-500">Vues totales</p>
                <p class="mt-3 text-3xl font-semibold text-slate-950">{{ number_format($totalViews) }}</p>
                <p class="mt-1 text-xs text-slate-400">{{ number_format($totalLikes) }} likes cumules</p>
            </div>
            <div class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                <p class="text-sm font-medium text-slate-500">Commentaires</p>
                <p class="mt-3 text-3xl font-semibold text-slate-950">{{ $pendingCommentsCount }}</p>
                <p class="mt-1 text-xs text-slate-400">{{ $approvedCommentsCount }} approuves, {{ $subscribersCount }} abonnes</p>
            </div>
        </div>

        @php
            $publishedPercent = $postsCount > 0 ? round(($publishedPostsCount / $postsCount) * 100) : 0;
            $draftPercent = $postsCount > 0 ? round(($draftPostsCount / $postsCount) * 100) : 0;
            $mediaPercent = $projectsCount > 0 ? round(($mediaCount / $projectsCount) * 100) : 0;
            $commentTotal = $pendingCommentsCount + $approvedCommentsCount;
            $approvedPercent = $commentTotal > 0 ? round(($approvedCommentsCount / $commentTotal) * 100) : 0;
            $maxTopViews = max($topPosts->max('views') ?? 0, 1);
        @endphp

        <div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-950 text-white shadow-xl">
                <div class="relative p-6">
                    <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-blue-500/20 blur-2xl"></div>
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-300">Graphiques</p>
                    <h2 class="mt-2 text-2xl font-semibold">Sante du contenu</h2>
                    <p class="mt-2 text-sm text-slate-300">Une lecture rapide de la publication, des medias et de la moderation.</p>

                    <div class="mt-6 grid gap-4">
                        <div>
                            <div class="mb-2 flex justify-between text-sm">
                                <span>Articles publies</span>
                                <span>{{ $publishedPercent }}%</span>
                            </div>
                            <div class="h-3 rounded-full bg-white/10">
                                <div class="h-3 rounded-full bg-gradient-to-r from-sky-400 to-blue-500" style="width: {{ $publishedPercent }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-2 flex justify-between text-sm">
                                <span>Brouillons</span>
                                <span>{{ $draftPercent }}%</span>
                            </div>
                            <div class="h-3 rounded-full bg-white/10">
                                <div class="h-3 rounded-full bg-gradient-to-r from-slate-400 to-slate-200" style="width: {{ $draftPercent }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-2 flex justify-between text-sm">
                                <span>Part des medias</span>
                                <span>{{ $mediaPercent }}%</span>
                            </div>
                            <div class="h-3 rounded-full bg-white/10">
                                <div class="h-3 rounded-full bg-gradient-to-r from-blue-500 to-indigo-300" style="width: {{ $mediaPercent }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-2 flex justify-between text-sm">
                                <span>Commentaires approuves</span>
                                <span>{{ $approvedPercent }}%</span>
                            </div>
                            <div class="h-3 rounded-full bg-white/10">
                                <div class="h-3 rounded-full bg-gradient-to-r from-emerald-300 to-sky-400" style="width: {{ $approvedPercent }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-blue-600">Audience</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-950">Top vues articles</h2>
                    </div>
                    <div class="grid h-28 w-28 place-items-center rounded-full" style="background: conic-gradient(#2563eb 0 {{ min($publishedPercent, 100) }}%, #e2e8f0 {{ min($publishedPercent, 100) }}% 100%);">
                        <div class="grid h-20 w-20 place-items-center rounded-full bg-white text-center">
                            <span class="text-xl font-bold text-slate-950">{{ $publishedPercent }}%</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    @forelse($topPosts as $post)
                        <div>
                            <div class="mb-2 flex items-center justify-between gap-4 text-sm">
                                <span class="truncate font-semibold text-slate-700">{{ $post->title }}</span>
                                <span class="shrink-0 text-slate-500">{{ $post->views }} vues</span>
                            </div>
                            <div class="h-3 rounded-full bg-slate-100">
                                <div class="h-3 rounded-full bg-gradient-to-r from-slate-950 to-blue-600" style="width: {{ max(6, round(($post->views / $maxTopViews) * 100)) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Aucune statistique disponible.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
            <section class="rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 p-5">
                    <h2 class="text-lg font-semibold text-slate-950">Articles recents</h2>
                    <p class="text-sm text-slate-500">Etat de publication et categorie.</p>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($latestPosts as $post)
                        <div class="flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $post->title }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $post->category?->name ?? 'Sans categorie' }} - {{ $post->views }} vues - {{ $post->likes }} likes</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ $post->status === 'published' ? 'Publie' : 'Brouillon' }}</span>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:border-teal-400 hover:text-teal-700">Editer</a>
                            </div>
                        </div>
                    @empty
                        <p class="p-5 text-sm text-slate-500">Aucun article pour le moment.</p>
                    @endforelse
                </div>
            </section>

            <section class="rounded-lg border border-slate-200 bg-slate-950 text-white shadow-sm">
                <div class="border-b border-white/10 p-5">
                    <h2 class="text-lg font-semibold">Actions rapides</h2>
                    <p class="text-sm text-slate-300">Les raccourcis utiles du quotidien.</p>
                </div>
                <div class="grid gap-3 p-5">
                    <a href="{{ route('admin.posts.index') }}" class="rounded-lg bg-white/10 p-4 text-sm font-semibold transition hover:bg-white/15">Gerer les articles</a>
                    <a href="{{ route('admin.portfolios.index') }}" class="rounded-lg bg-white/10 p-4 text-sm font-semibold transition hover:bg-white/15">Publier medias et portfolio</a>
                    <a href="{{ route('admin.comments.index') }}" class="rounded-lg bg-white/10 p-4 text-sm font-semibold transition hover:bg-white/15">Moderation des commentaires</a>
                    <a href="{{ route('admin.categories.index') }}" class="rounded-lg bg-white/10 p-4 text-sm font-semibold transition hover:bg-white/15">Organiser les categories</a>
                </div>
            </section>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 p-5">
                    <h2 class="text-lg font-semibold text-slate-950">Top articles</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($topPosts as $post)
                        <div class="flex items-center justify-between gap-4 p-4">
                            <span class="truncate text-sm font-medium text-slate-700">{{ $post->title }}</span>
                            <span class="shrink-0 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $post->views }} vues</span>
                        </div>
                    @empty
                        <p class="p-5 text-sm text-slate-500">Aucune statistique disponible.</p>
                    @endforelse
                </div>
            </section>

            <section class="rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 p-5">
                    <h2 class="text-lg font-semibold text-slate-950">Derniers medias</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($latestMedia as $item)
                        <div class="flex items-center justify-between gap-4 p-4">
                            <span class="truncate text-sm font-medium text-slate-700">{{ $item->title }}</span>
                            <a href="{{ route('admin.portfolios.edit', $item) }}" class="shrink-0 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:border-teal-400 hover:text-teal-700">Editer</a>
                        </div>
                    @empty
                        <p class="p-5 text-sm text-slate-500">Aucun media publie. Creez une categorie de type Media puis ajoutez un element.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
