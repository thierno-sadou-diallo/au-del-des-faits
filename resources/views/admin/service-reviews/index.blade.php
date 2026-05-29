<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="admin-kicker">Services</p>
                <h1 class="mt-1 text-3xl font-semibold text-white">Avis et réponses</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-200">Répondez publiquement aux avis laissés sur la page Services, dans un fil clair et professionnel.</p>
            </div>
            <a href="{{ route('services') }}#avis-services" class="rounded-xl border border-white/20 bg-white/10 px-4 py-2 text-sm font-black text-white transition hover:bg-white/15" target="_blank">Voir côté site</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-5 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="admin-card rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm font-bold text-slate-500">Total avis</p>
                <p class="mt-3 text-3xl font-black text-slate-950">{{ $reviewStats['total'] }}</p>
            </div>
            <div class="admin-card rounded-2xl border border-amber-200 bg-amber-50 p-5">
                <p class="text-sm font-bold text-amber-800">À approuver</p>
                <p class="mt-3 text-3xl font-black text-slate-950">{{ $reviewStats['pending'] }}</p>
            </div>
            <div class="admin-card rounded-2xl border border-blue-200 bg-blue-50 p-5">
                <p class="text-sm font-bold text-blue-800">Répondus</p>
                <p class="mt-3 text-3xl font-black text-slate-950">{{ $reviewStats['answered'] }}</p>
            </div>
            <div class="admin-card rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-sm font-bold text-slate-500">Sans réponse</p>
                <p class="mt-3 text-3xl font-black text-slate-950">{{ $reviewStats['unanswered'] }}</p>
            </div>
        </div>

        <div class="admin-card flex flex-wrap gap-2 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
            @foreach([
                'all' => 'Tous',
                'pending' => 'À approuver',
                'unanswered' => 'Sans réponse',
                'answered' => 'Répondus',
            ] as $key => $label)
                <a href="{{ route('admin.service-reviews.index', ['status' => $key]) }}" class="rounded-xl px-4 py-2 text-sm font-black transition {{ $status === $key ? 'bg-slate-950 text-white' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @forelse($reviews as $review)
            <article class="admin-card overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 p-5">
                    <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-lg font-black text-slate-950">{{ $review->name }}</h2>
                                @if($review->is_approved)
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-700">Visible</span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-black text-amber-700">À approuver</span>
                                @endif
                                @if($review->admin_reply)
                                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-700">Répondu</span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ $review->email }}
                                @if($review->organization)
                                    - {{ $review->organization }}
                                @endif
                            </p>
                            <div class="mt-2 flex items-center gap-1 text-amber-500">
                                @for($star = 1; $star <= 5; $star++)
                                    <span>{{ $star <= $review->rating ? '★' : '☆' }}</span>
                                @endfor
                                <span class="ml-2 text-xs font-semibold text-slate-400">{{ $review->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @if(! $review->is_approved)
                                <form method="POST" action="{{ route('admin.service-reviews.approve', $review) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700 hover:bg-emerald-100">Approuver</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.service-reviews.destroy', $review) }}" onsubmit="return confirm('Supprimer cet avis ?')">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-full border border-red-200 bg-red-50 px-4 py-2 text-sm font-bold text-red-700 hover:bg-red-100">Supprimer</button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-4 rounded-2xl bg-slate-50 p-4 text-slate-700">
                        {!! nl2br(e($review->message)) !!}
                    </div>
                </div>

                <div class="grid gap-5 p-5 lg:grid-cols-[1fr_400px]">
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-[0.18em] text-slate-500">Conversation publique</h3>
                        <div class="mt-4 space-y-3">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="font-black text-slate-950">{{ $review->name }}</p>
                                <p class="mt-2 text-slate-700">{!! nl2br(e($review->message)) !!}</p>
                            </div>

                            @if($review->admin_reply)
                                <div class="ml-6 rounded-2xl border border-blue-100 bg-blue-50 p-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <p class="font-black text-slate-950">{{ $review->admin_reply_author ?: 'Au-delà des faits' }}</p>
                                        <span class="rounded-full bg-blue-600 px-2.5 py-1 text-xs font-black text-white">Réponse admin</span>
                                        <span class="text-xs font-semibold text-slate-400">{{ $review->replied_at?->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <p class="mt-2 text-slate-700">{!! nl2br(e($review->admin_reply)) !!}</p>
                                </div>
                            @else
                                <p class="ml-6 rounded-2xl border border-dashed border-slate-200 p-4 text-sm font-semibold text-slate-500">Aucune réponse publiée pour le moment.</p>
                            @endif
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.service-reviews.reply', $review) }}" class="rounded-2xl border border-slate-200 bg-white/80 p-4 shadow-sm">
                        @csrf
                        <h3 class="text-base font-black text-slate-950">{{ $review->admin_reply ? 'Modifier la réponse' : 'Répondre publiquement' }}</h3>
                        <p class="mt-1 text-sm text-slate-500">La réponse sera affichée sous l’avis sur la page Services.</p>

                        <label class="mt-4 block text-sm font-bold text-slate-700" for="reply-author-{{ $review->id }}">Signature affichée</label>
                        <input id="reply-author-{{ $review->id }}" name="admin_reply_author" type="text" value="{{ old('admin_reply_author', $review->admin_reply_author ?: 'Au-delà des faits') }}" class="mt-1 w-full rounded-xl border-slate-200" maxlength="120">

                        <label class="mt-4 block text-sm font-bold text-slate-700" for="reply-message-{{ $review->id }}">Réponse</label>
                        <textarea id="reply-message-{{ $review->id }}" name="admin_reply" rows="6" class="mt-1 w-full rounded-xl border-slate-200" placeholder="Merci pour votre retour. Votre avis nous aide à améliorer..." required>{{ old('admin_reply', $review->admin_reply) }}</textarea>

                        <button class="mt-4 w-full rounded-xl bg-slate-950 px-4 py-3 text-sm font-black text-white transition hover:bg-blue-700">
                            Publier la réponse
                        </button>
                    </form>
                </div>
            </article>
        @empty
            <div class="admin-card rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm">
                <p class="font-bold text-slate-600">Aucun avis service pour le moment.</p>
            </div>
        @endforelse

        <div>{{ $reviews->links() }}</div>
    </div>
</x-app-layout>
