<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="admin-kicker">Pilotage</p>
                <h1 class="mt-1 text-3xl font-semibold text-white">Tableau de bord administrateur</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-200">Suivez les vues, les likes, les articles publies, les medias, les commentaires et les demandes de rendez-vous.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.posts.create') }}" class="rounded-xl bg-white px-4 py-2 text-sm font-black text-slate-950 shadow-sm transition hover:bg-amber-100">Nouvel article</a>
                <a href="{{ route('admin.portfolios.create') }}" class="rounded-xl border border-white/20 bg-white/10 px-4 py-2 text-sm font-black text-white transition hover:bg-white/15">Nouveau media</a>
                <a href="{{ route('admin.availability-slots.create') }}" class="rounded-xl border border-amber-300/40 bg-amber-300/15 px-4 py-2 text-sm font-black text-amber-100 transition hover:bg-amber-300/25">Nouveau creneau</a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
        @endif

        @php
            $pendingAppointmentAlerts = $latestAppointments->where('status', 'pending')->take(6);
            $publishedPercent = $postsCount > 0 ? round(($publishedPostsCount / $postsCount) * 100) : 0;
            $draftPercent = $postsCount > 0 ? round(($draftPostsCount / $postsCount) * 100) : 0;
            $mediaPercent = $projectsCount > 0 ? round(($mediaCount / $projectsCount) * 100) : 0;
            $commentTotal = $pendingCommentsCount + $approvedCommentsCount;
            $approvedPercent = $commentTotal > 0 ? round(($approvedCommentsCount / $commentTotal) * 100) : 0;
            $maxTopViews = max($topPosts->max('views') ?? 0, 1);
        @endphp

        @if ($pendingAppointmentAlerts->isNotEmpty())
            <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div class="font-black text-slate-950">Demandes de rendez-vous en attente</div>
                    <small class="font-bold text-amber-800">{{ $pendingAppointmentAlerts->count() }} à traiter</small>
                </div>
                <ul class="mt-3 space-y-2">
                    @foreach ($pendingAppointmentAlerts as $appointment)
                        <li>
                            <a href="{{ route('admin.appointments.show', $appointment) }}" class="font-semibold text-slate-800 hover:text-teal-700">
                                {{ $appointment->name }} - {{ Str::limit($appointment->subject, 60) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <div class="admin-card rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm font-bold text-slate-500">Articles publies</p>
                <p class="mt-3 text-3xl font-black text-slate-950">{{ $publishedPostsCount }}</p>
                <p class="mt-1 text-xs font-semibold text-slate-400">{{ $draftPostsCount }} brouillons sur {{ $postsCount }} articles</p>
            </div>
            <div class="admin-card rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm font-bold text-slate-500">Medias</p>
                <p class="mt-3 text-3xl font-black text-slate-950">{{ $mediaCount }}</p>
                <p class="mt-1 text-xs font-semibold text-slate-400">{{ $projectsCount }} elements portfolio</p>
            </div>
            <div class="admin-card rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm font-bold text-slate-500">Vues totales</p>
                <p class="mt-3 text-3xl font-black text-slate-950">{{ number_format($totalViews) }}</p>
                <p class="mt-1 text-xs font-semibold text-slate-400">{{ number_format($totalLikes) }} likes cumules</p>
            </div>
            <div class="admin-card rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm font-bold text-slate-500">Commentaires</p>
                <p class="mt-3 text-3xl font-black text-slate-950">{{ $pendingCommentsCount }}</p>
                <p class="mt-1 text-xs font-semibold text-slate-400">{{ $approvedCommentsCount }} approuves, {{ $subscribersCount }} abonnes</p>
            </div>
            <div class="admin-card rounded-2xl border border-amber-200 bg-amber-50 p-5">
                <p class="text-sm font-bold text-amber-800">RDV en attente</p>
                <p class="mt-3 text-3xl font-black text-slate-950">{{ $pendingAppointmentsCount }}</p>
                <p class="mt-1 text-xs font-semibold text-amber-800">{{ $confirmedAppointmentsCount }} approuves, {{ $availableSlotsCount }} creneaux ouverts</p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
            <section class="overflow-hidden rounded-3xl border border-slate-200 bg-slate-950 text-white shadow-xl">
                <div class="relative p-6">
                    <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-blue-500/20 blur-2xl"></div>
                    <p class="text-sm font-black uppercase tracking-[0.24em] text-sky-300">Graphiques</p>
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

            <section class="admin-card rounded-3xl border border-slate-200 bg-white p-6">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.24em] text-blue-600">Audience</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-950">Top vues articles</h2>
                    </div>
                    <div class="grid h-28 w-28 place-items-center rounded-full" style="background: conic-gradient(#2563eb 0 {{ min($publishedPercent, 100) }}%, #e2e8f0 {{ min($publishedPercent, 100) }}% 100%);">
                        <div class="grid h-20 w-20 place-items-center rounded-full bg-white text-center">
                            <span class="text-xl font-black text-slate-950">{{ $publishedPercent }}%</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    @forelse($topPosts as $post)
                        <div>
                            <div class="mb-2 flex items-center justify-between gap-4 text-sm">
                                <span class="truncate font-bold text-slate-700">{{ $post->title }}</span>
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

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="admin-card rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.24em] text-teal-700">Publications</p>
                        <h2 class="mt-2 text-xl font-semibold text-slate-950">Évolution sur 6 mois</h2>
                    </div>
                    <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-black text-teal-700">{{ $publishedPostsCount }} publiés</span>
                </div>
                @php
                    $maxTrend = max($publicationTrend->max('count') ?? 0, 1);
                @endphp
                <div class="mt-6 flex h-56 items-end gap-3 rounded-2xl border border-slate-100 bg-slate-50 p-4">
                    @foreach($publicationTrend as $item)
                        @php $height = max(10, round(($item['count'] / $maxTrend) * 100)); @endphp
                        <div class="flex h-full flex-1 flex-col justify-end gap-2">
                            <div class="flex flex-1 items-end">
                                <div class="w-full rounded-t-xl bg-gradient-to-t from-teal-700 to-emerald-400" style="height: {{ $height }}%"></div>
                            </div>
                            <div class="text-center">
                                <p class="text-xs font-black text-slate-800">{{ $item['count'] }}</p>
                                <p class="mt-1 text-[0.68rem] font-semibold text-slate-500">{{ $item['label'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="admin-card rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.24em] text-amber-700">Catégories</p>
                        <h2 class="mt-2 text-xl font-semibold text-slate-950">Articles publiés par thème</h2>
                    </div>
                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-black text-amber-700">Top 5</span>
                </div>
                @php
                    $maxCategory = max($publishedByCategory->max('count') ?? 0, 1);
                @endphp
                <div class="mt-6 space-y-4">
                    @forelse($publishedByCategory as $item)
                        <div>
                            <div class="mb-2 flex justify-between gap-4 text-sm">
                                <span class="truncate font-bold text-slate-700">{{ $item['label'] }}</span>
                                <span class="shrink-0 font-black text-slate-950">{{ $item['count'] }}</span>
                            </div>
                            <div class="h-3 rounded-full bg-slate-100">
                                <div class="h-3 rounded-full bg-gradient-to-r from-amber-500 to-teal-600" style="width: {{ max(8, round(($item['count'] / $maxCategory) * 100)) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="rounded-2xl border border-slate-100 bg-slate-50 p-4 text-sm text-slate-500">Aucune catégorie publiée pour le moment.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
            <section class="admin-card rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 p-5">
                    <h2 class="text-lg font-semibold text-slate-950">Articles recents</h2>
                    <p class="text-sm text-slate-500">Etat de publication, categorie, vues et likes.</p>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($latestPosts as $post)
                        <div class="flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $post->title }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $post->category?->name ?? 'Sans categorie' }} - {{ $post->views }} vues - {{ $post->likes }} likes</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="rounded-full px-3 py-1 text-xs font-black {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ $post->status === 'published' ? 'Publie' : 'Brouillon' }}</span>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-black text-slate-700 transition hover:border-teal-400 hover:text-teal-700">Editer</a>
                            </div>
                        </div>
                    @empty
                        <p class="p-5 text-sm text-slate-500">Aucun article pour le moment.</p>
                    @endforelse
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-slate-950 text-white shadow-sm">
                <div class="border-b border-white/10 p-5">
                    <h2 class="text-lg font-semibold">Actions rapides</h2>
                    <p class="text-sm text-slate-300">Les raccourcis utiles du quotidien.</p>
                </div>
                <div class="grid gap-3 p-5">
                    <a href="{{ route('admin.posts.index') }}" class="rounded-xl bg-white/10 p-4 text-sm font-black transition hover:bg-white/15">Gerer les articles</a>
                    <a href="{{ route('admin.posts.create') }}" class="rounded-xl bg-white/10 p-4 text-sm font-black transition hover:bg-white/15">Creer avec l'assistant IA</a>
                    <a href="{{ route('admin.portfolios.index') }}" class="rounded-xl bg-white/10 p-4 text-sm font-black transition hover:bg-white/15">Publier medias et portfolio</a>
                    <a href="{{ route('admin.comments.index') }}" class="rounded-xl bg-white/10 p-4 text-sm font-black transition hover:bg-white/15">Moderation des commentaires</a>
                    <a href="{{ route('admin.appointments.index') }}" class="rounded-xl bg-white/10 p-4 text-sm font-black transition hover:bg-white/15">Voir les demandes de rendez-vous</a>
                    <a href="{{ route('admin.availability-slots.index') }}" class="rounded-xl bg-white/10 p-4 text-sm font-black transition hover:bg-white/15">Gerer les creneaux</a>
                </div>
            </section>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
            <section class="admin-card rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-950">Demandes de rendez-vous</h2>
                        <p class="text-sm text-slate-500">Les nouvelles demandes arrivent aussi dans les notifications.</p>
                    </div>
                    <a href="{{ route('admin.appointments.index') }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-black text-slate-700 hover:border-teal-400 hover:text-teal-700">Tout voir</a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($latestAppointments as $appointment)
                        <div class="flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $appointment->name }}</p>
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ Str::limit($appointment->subject, 64) }}
                                    @if($appointment->availabilitySlot)
                                        - {{ $appointment->availabilitySlot->start_time->format('d/m/Y H:i') }}
                                    @endif
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="rounded-full px-3 py-1 text-xs font-black
                                    @if($appointment->status === 'confirmed') bg-emerald-50 text-emerald-700
                                    @elseif($appointment->status === 'cancelled') bg-rose-50 text-rose-700
                                    @elseif($appointment->status === 'completed') bg-blue-50 text-blue-700
                                    @else bg-amber-50 text-amber-700 @endif">
                                    {{ $appointment->status === 'pending' ? 'En attente' : ($appointment->status === 'confirmed' ? 'Approuve' : ($appointment->status === 'completed' ? 'Termine' : 'Annule')) }}
                                </span>
                                <a href="{{ route('admin.appointments.show', $appointment) }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-black text-slate-700 transition hover:border-teal-400 hover:text-teal-700">Traiter</a>
                            </div>
                        </div>
                    @empty
                        <p class="p-5 text-sm text-slate-500">Aucune demande de rendez-vous pour le moment.</p>
                    @endforelse
                </div>
            </section>

            <section class="admin-card rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 p-5">
                    <h2 class="text-lg font-semibold text-slate-950">Derniers medias</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($latestMedia as $item)
                        <div class="flex items-center justify-between gap-4 p-4">
                            <span class="truncate text-sm font-bold text-slate-700">{{ $item->title }}</span>
                            <a href="{{ route('admin.portfolios.edit', $item) }}" class="shrink-0 rounded-xl border border-slate-200 px-3 py-2 text-xs font-black text-slate-700 hover:border-teal-400 hover:text-teal-700">Editer</a>
                        </div>
                    @empty
                        <p class="p-5 text-sm text-slate-500">Aucun media publie. Creez une categorie de type Media puis ajoutez un element.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
