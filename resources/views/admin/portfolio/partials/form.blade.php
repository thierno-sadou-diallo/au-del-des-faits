@if ($errors->any())
    <div class="rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
        <p class="font-semibold">Merci de corriger les champs signales.</p>
        <ul class="mt-2 list-disc space-y-1 ps-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-6 lg:grid-cols-[1fr_340px]">
    <div class="space-y-5 rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="title">Titre</label>
            <input id="title" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="title" value="{{ old('title', $project->title ?? '') }}" required>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="description">Description</label>
            <textarea id="description" class="min-h-[260px] w-full rounded-lg border-slate-300 text-sm leading-7 focus:border-teal-500 focus:ring-teal-500" rows="10" name="description" required>{{ old('description', $project->description ?? '') }}</textarea>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700" for="link">Lien externe</label>
                <input id="link" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="link" placeholder="https://..." value="{{ old('link', $project->link ?? '') }}">
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700" for="video_url">Video</label>
                <input id="video_url" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="video_url" placeholder="https://youtube.com/..." value="{{ old('video_url', $project->video_url ?? '') }}">
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="technologies">Mots cles / technologies</label>
            <input id="technologies" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="technologies" placeholder="Interview, TV, terrain" value="{{ old('technologies', isset($project) ? implode(', ', $project->technologies ?? []) : '') }}">
        </div>
    </div>

    <aside class="space-y-5">
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">Classement</h2>
            <div class="mt-4">
                <label class="mb-2 block text-sm font-semibold text-slate-700" for="category_id">Categorie</label>
                <select id="category_id" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="category_id">
                    <option value="">Sans categorie</option>
                    @foreach($categories->groupBy('type') as $type => $groupedCategories)
                        <optgroup label="{{ ucfirst($type) }}">
                            @foreach($groupedCategories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $project->category_id ?? '') == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                <p class="mt-3 text-xs text-slate-500">Choisissez une categorie de type Media pour l'afficher dans la page Medias.</p>
            </div>
            <button class="mt-5 w-full rounded-lg bg-slate-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-teal-700">Enregistrer</button>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <label class="mb-3 block text-sm font-semibold text-slate-700" for="images">Images</label>
            @if(!empty($project?->images))
                <div class="mb-4 grid grid-cols-2 gap-2">
                    @foreach($project->images as $image)
                        <img class="aspect-video w-full rounded-lg object-cover" src="{{ asset('storage/'.$image) }}" alt="{{ $project->title }}">
                    @endforeach
                </div>
            @endif
            <div id="images-preview" class="mb-4 hidden grid-cols-2 gap-2"></div>
            <input id="images" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-slate-950 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-teal-700" type="file" name="images[]" multiple accept="image/*">
            <p class="mt-3 text-xs text-slate-500">Ajoutez une ou plusieurs images. Lors d'une modification, un nouvel envoi remplace les anciennes images.</p>
            <p id="images-count" class="mt-2 text-xs font-semibold text-teal-700"></p>
        </div>
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
            count.textContent = files.length ? `${files.length} image(s) selectionnee(s)` : '';

            files.forEach((file) => {
                const image = document.createElement('img');
                image.className = 'aspect-video w-full rounded-lg object-cover ring-1 ring-slate-200';
                image.alt = file.name;
                image.src = URL.createObjectURL(file);
                image.onload = () => URL.revokeObjectURL(image.src);
                preview.appendChild(image);
            });
        });
    })();
</script>
