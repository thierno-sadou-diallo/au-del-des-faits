<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="admin-kicker">Discussions</p>
            <h2 class="text-2xl font-black">Commentaires et réponses</h2>
            <p class="mt-2 text-sm text-slate-200">Modérez les commentaires publics et répondez avec une signature personnalisée.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl p-6">
        <div class="space-y-5">
            @forelse($comments as $comment)
                <article class="admin-card overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 p-5">
                        <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-lg font-black text-slate-950">{{ $comment->name }}</h3>
                                    @if($comment->is_approved)
                                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-black text-emerald-700">Approuvé</span>
                                    @else
                                        <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-black text-amber-700">En attente</span>
                                    @endif
                                </div>
                                <p class="mt-1 text-sm text-slate-500">
                                    @if($comment->commentable_type === 'App\\Models\\Portfolio')
                                        Média :
                                        <a href="{{ route('portfolio.show', $comment->commentable->slug) }}" class="font-bold text-blue-700 hover:text-blue-900" target="_blank">
                                            {{ $comment->commentable->title }}
                                        </a>
                                    @else
                                        Article :
                                        <a href="{{ route('blog.show', $comment->post->slug) }}" class="font-bold text-blue-700 hover:text-blue-900" target="_blank">
                                            {{ $comment->post->title }}
                                        </a>
                                    @endif
                                </p>
                                <p class="text-xs text-slate-400">{{ $comment->created_at->format('d/m/Y H:i') }} - {{ $comment->email }}</p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                @if(!$comment->is_approved)
                                    <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700 transition hover:bg-emerald-100">
                                            Approuver
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" onsubmit="return confirm('Supprimer ce commentaire et ses réponses ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-full border border-red-200 bg-red-50 px-4 py-2 text-sm font-bold text-red-700 transition hover:bg-red-100">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="mt-4 rounded-2xl bg-slate-50 p-4 text-slate-700">
                            {!! nl2br(e($comment->message)) !!}
                        </div>
                    </div>

                    <div class="grid gap-5 p-5 lg:grid-cols-[1fr_380px]">
                        <div>
                            <h4 class="text-sm font-black uppercase tracking-[0.18em] text-slate-500">
                                @if($comment->commentable_type === 'App\\Models\\Portfolio')
                                    Discussion visible sur le média
                                @else
                                    Discussion visible sur l'article
                                @endif
                            </h4>
                            <div class="mt-4 space-y-3">
                                @forelse($comment->replies as $reply)
                                    <div class="rounded-2xl border border-blue-100 bg-blue-50/70 p-4">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="font-black text-slate-950">{{ $reply->name }}</p>
                                            <span class="rounded-full bg-blue-600 px-2.5 py-1 text-xs font-black text-white">Réponse admin</span>
                                            <span class="text-xs font-semibold text-slate-400">{{ $reply->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        <p class="mt-2 text-slate-700">{!! nl2br(e($reply->message)) !!}</p>
                                    </div>
                                @empty
                                    <p class="rounded-2xl border border-dashed border-slate-200 p-4 text-sm font-semibold text-slate-500">
                                        Aucune réponse pour le moment.
                                    </p>
                                @endforelse
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.comments.reply', $comment) }}" class="rounded-2xl border border-slate-200 bg-white/80 p-4 shadow-sm">
                            @csrf
                            <h4 class="text-base font-black text-slate-950">Répondre publiquement</h4>
                            <p class="mt-1 text-sm text-slate-500">Cette réponse sera visible sous le commentaire dans l'article.</p>

                            <label class="mt-4 block text-sm font-bold text-slate-700" for="reply-name-{{ $comment->id }}">Signature affichée</label>
                            <input id="reply-name-{{ $comment->id }}" name="name" type="text" value="Au-delà des faits" class="mt-1 w-full rounded-xl border-slate-200" maxlength="255">

                            <label class="mt-4 block text-sm font-bold text-slate-700" for="reply-message-{{ $comment->id }}">Message personnalisé</label>
                            <textarea id="reply-message-{{ $comment->id }}" name="message" rows="5" class="mt-1 w-full rounded-xl border-slate-200" placeholder="Merci pour votre contribution. Votre remarque ouvre une piste importante..." required></textarea>

                            <button class="mt-4 w-full rounded-xl bg-slate-950 px-4 py-3 text-sm font-black text-white transition hover:bg-blue-700">
                                Publier la réponse
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="admin-card rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-sm">
                    <p class="font-bold text-slate-600">Aucun commentaire pour le moment.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $comments->links() }}
        </div>
    </div>
</x-app-layout>
