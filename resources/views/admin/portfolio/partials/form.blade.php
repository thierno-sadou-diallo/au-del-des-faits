@if ($errors->any())
    <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
        <p class="font-semibold">Merci de corriger les champs signalés.</p>
        <ul class="mt-2 list-disc space-y-1 ps-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-6 lg:grid-cols-[1fr_340px]">
    <div class="space-y-5">
        <section class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700" for="title">Titre du média</label>
                <input id="title" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="title" value="{{ old('title', $project->title ?? '') }}" placeholder="Ex: Rencontre communautaire à Bamako" required>
            </div>

            <div class="mt-5">
                <label class="mb-2 block text-sm font-semibold text-slate-700" for="description">Texte accompagnant les images</label>
                <textarea id="description" class="min-h-[360px] w-full rounded-lg border-slate-300 text-sm leading-7 focus:border-teal-500 focus:ring-teal-500" rows="14" name="description" placeholder="Rédigez le contexte, le lieu, les personnes concernées, l’objectif du média et les informations importantes..." required>{{ old('description', $project->description ?? '') }}</textarea>
                <p class="mt-2 text-xs text-slate-500">Ce texte sera affiché avec les images sur la page publique du média.</p>
            </div>
        </section>

        <section class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-950">Images à publier</h2>
                    <p class="text-sm text-slate-500">Ajoutez une ou plusieurs images. La première image sert de visuel principal.</p>
                </div>
                <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-black text-teal-700">JPG, PNG, WebP</span>
            </div>

            @if(!empty($project?->images))
                <div class="mt-5">
                    <p class="mb-3 text-xs font-black uppercase tracking-[0.18em] text-slate-400">Images actuelles</p>
                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($project->images as $image)
                            <img class="aspect-video w-full rounded-xl object-cover ring-1 ring-slate-200" src="{{ asset('storage/'.$image) }}" alt="{{ $project->title }}">
                        @endforeach
                    </div>
                    <p class="mt-3 text-xs text-amber-700">Un nouvel envoi remplacera toutes les images actuelles.</p>
                </div>
            @endif

            <div id="images-preview" class="mt-5 hidden grid-cols-2 gap-3 lg:grid-cols-3"></div>

            <label for="images" class="mt-5 flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-center transition hover:border-teal-400 hover:bg-teal-50/50">
                <span class="text-sm font-black text-slate-900">Sélectionner des images</span>
                <span class="mt-1 text-xs text-slate-500">Vous pouvez choisir plusieurs fichiers à la fois.</span>
                <input id="images" class="sr-only" type="file" name="images[]" multiple accept="image/*">
            </label>
            <p id="images-count" class="mt-3 text-xs font-semibold text-teal-700"></p>
        </section>

        <section class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-950">Informations complémentaires</h2>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700" for="link">Lien externe</label>
                    <input id="link" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="link" placeholder="https://..." value="{{ old('link', $project->link ?? '') }}">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700" for="video_url">Lien vidéo</label>
                    <input id="video_url" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="video_url" placeholder="https://youtube.com/..." value="{{ old('video_url', $project->video_url ?? '') }}">
                </div>
            </div>

            <div class="mt-4">
                <label class="mb-2 block text-sm font-semibold text-slate-700" for="technologies">Mots-clés</label>
                <input id="technologies" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="technologies" placeholder="Terrain, conférence, jeunesse, médias" value="{{ old('technologies', isset($project) ? implode(', ', $project->technologies ?? []) : '') }}">
                <p class="mt-2 text-xs text-slate-500">Séparez les mots-clés par des virgules.</p>
            </div>
        </section>
    </div>

    <aside class="space-y-5">
        <section class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-black uppercase tracking-[0.18em] text-slate-500">Publication</h2>
            <div class="mt-4">
                <label class="mb-2 block text-sm font-semibold text-slate-700" for="category_id">Catégorie</label>
                <select id="category_id" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="category_id">
                    <option value="">Sans catégorie</option>
                    @foreach($categories->groupBy('type') as $type => $groupedCategories)
                        <optgroup label="{{ $type === 'media' ? 'Médias' : 'Portfolio' }}">
                            @foreach($groupedCategories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $project->category_id ?? '') == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                <p class="mt-3 text-xs text-slate-500">Choisissez une catégorie de type Médias pour l’afficher dans la page Médias.</p>
            </div>

            <button class="mt-5 w-full rounded-xl bg-slate-950 px-4 py-3 text-sm font-black text-white transition hover:bg-teal-700">Publier le média</button>
            <a href="{{ route('admin.portfolios.index') }}" class="mt-3 block rounded-xl border border-slate-200 px-4 py-3 text-center text-sm font-black text-slate-700 hover:border-teal-400 hover:text-teal-700">Annuler</a>
        </section>

        <section class="rounded-2xl border border-amber-200 bg-amber-50 p-5 text-sm text-amber-900">
            <p class="font-black">Bon format</p>
            <p class="mt-2 leading-6">Un média professionnel associe un titre précis, des images nettes et un texte de contexte: date, lieu, enjeu et message principal.</p>
        </section>

        @isset($project)
            <section class="admin-card rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-black uppercase tracking-[0.18em] text-slate-500">Statistiques</h2>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-bold text-slate-500">Vues</p>
                        <p class="mt-1 text-2xl font-black text-slate-950">{{ number_format($project->views) }}</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-bold text-slate-500">Likes</p>
                        <p class="mt-1 text-2xl font-black text-slate-950">{{ number_format($project->likes) }}</p>
                    </div>
                </div>
            </section>
        @endisset
    </aside>
</div>

<script>
    (() => {
        const input = document.getElementById('images');
        const preview = document.getElementById('images-preview');
        const count = document.getElementById('images-count');

        input?.addEventListener('change', () => {
            preview.innerHTML = '';
            const files = Array.from(input.files || []);
            preview.classList.toggle('hidden', files.length === 0);
            preview.classList.toggle('grid', files.length > 0);
            count.textContent = files.length ? `${files.length} image(s) sélectionnée(s)` : '';

            files.forEach((file, index) => {
                const wrapper = document.createElement('div');
                wrapper.className = 'relative overflow-hidden rounded-xl ring-1 ring-slate-200';

                const image = document.createElement('img');
                image.className = 'aspect-video w-full object-cover';
                image.alt = file.name;
                image.src = URL.createObjectURL(file);
                image.onload = () => URL.revokeObjectURL(image.src);

                if (index === 0) {
                    const badge = document.createElement('span');
                    badge.className = 'absolute left-2 top-2 rounded-full bg-slate-950/85 px-2 py-1 text-[0.65rem] font-bold text-white';
                    badge.textContent = 'Image principale';
                    wrapper.appendChild(badge);
                }

                wrapper.appendChild(image);
                preview.appendChild(wrapper);
            });
        });
    })();
</script>
