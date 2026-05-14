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

<div class="grid gap-6 lg:grid-cols-[1fr_320px]">
    <div class="space-y-5 rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="title">Titre</label>
            <input id="title" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="title" value="{{ old('title', $post->title ?? '') }}" required>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="content">Contenu</label>
            <textarea id="content" class="min-h-[420px] w-full rounded-lg border-slate-300 text-sm leading-7 focus:border-teal-500 focus:ring-teal-500" name="content" rows="18" required>{{ old('content', $post->content ?? '') }}</textarea>
        </div>

        <div class="overflow-hidden rounded-3xl border border-amber-200 bg-[radial-gradient(circle_at_88%_12%,rgba(245,158,11,.22),transparent_12rem),linear-gradient(135deg,#fff7ed,#ffffff)] p-5 shadow-lg shadow-amber-900/5">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-amber-700">Assistant IA editorial</p>
                    <h3 class="mt-1 text-xl font-semibold text-slate-950">Rediger un article complet</h3>
                    <p class="mt-1 text-sm leading-6 text-slate-600">Generez un article entier, une structure, une introduction ou une conclusion a partir du titre et de l'angle editorial.</p>
                </div>
                <span class="rounded-full bg-slate-950 px-3 py-1 text-xs font-bold text-white">Assistant redaction</span>
            </div>

            <div class="mt-4 grid gap-3 md:grid-cols-[1fr_180px_160px]">
                <input id="ai-angle" class="rounded-lg border-amber-200 text-sm focus:border-amber-500 focus:ring-amber-500" type="text" placeholder="Angle souhaite: justice sociale, media, jeunesse..." />
                <select id="ai-tone" class="rounded-lg border-amber-200 text-sm focus:border-amber-500 focus:ring-amber-500">
                    <option value="professionnel">Ton professionnel</option>
                    <option value="engage">Ton engage</option>
                    <option value="pedagogique">Ton pedagogique</option>
                    <option value="editorial">Ton editorial</option>
                </select>
                <select id="ai-length" class="rounded-lg border-amber-200 text-sm focus:border-amber-500 focus:ring-amber-500">
                    <option value="standard">Article standard</option>
                    <option value="court">Article court</option>
                    <option value="long">Article long</option>
                </select>
            </div>

            <div class="mt-4 flex flex-wrap gap-2">
                <button type="button" class="ai-tool rounded-lg bg-slate-950 px-4 py-2 text-xs font-bold text-white transition hover:bg-amber-700" data-ai-action="full">Rediger l'article complet</button>
                <button type="button" class="ai-tool rounded-lg bg-white px-3 py-2 text-xs font-bold text-slate-900 ring-1 ring-amber-200 transition hover:bg-amber-100" data-ai-action="plan">Generer un plan</button>
                <button type="button" class="ai-tool rounded-lg bg-white px-3 py-2 text-xs font-bold text-slate-900 ring-1 ring-amber-200 transition hover:bg-amber-100" data-ai-action="intro">Introduction</button>
                <button type="button" class="ai-tool rounded-lg bg-white px-3 py-2 text-xs font-bold text-slate-900 ring-1 ring-amber-200 transition hover:bg-amber-100" data-ai-action="conclusion">Conclusion</button>
                <button type="button" class="ai-tool rounded-lg bg-white px-3 py-2 text-xs font-bold text-slate-900 ring-1 ring-amber-200 transition hover:bg-amber-100" data-ai-action="improve">Ameliorer la selection</button>
            </div>
            <p class="mt-3 text-xs text-slate-500">Pour la reformulation, selectionner un passage du contenu puis lancer l'amelioration.</p>
        </div>
    </div>

    <aside class="space-y-5">
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-500">Publication</h2>
            <div class="mt-4 space-y-4">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700" for="status">Statut</label>
                    <select id="status" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="status">
                        <option value="draft" @selected(old('status', $post->status ?? 'draft') === 'draft')>Brouillon</option>
                        <option value="published" @selected(old('status', $post->status ?? '') === 'published')>Publie</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700" for="category_id">Categorie</label>
                    <select id="category_id" class="w-full rounded-lg border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500" name="category_id">
                        <option value="">Sans categorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id ?? '') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="w-full rounded-lg bg-slate-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-teal-700">Enregistrer</button>
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <label class="mb-3 block text-sm font-semibold text-slate-700" for="image">Image principale</label>
            @if(!empty($post?->image))
                <img class="mb-4 aspect-video w-full rounded-lg object-cover" src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}">
            @endif
            <input id="image" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-slate-950 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-teal-700" type="file" name="image" accept="image/*">
            <p class="mt-3 text-xs text-slate-500">Format image, 2 Mo maximum.</p>
        </div>
    </aside>
</div>

<script>
    (() => {
        const titleInput = document.getElementById('title');
        const contentInput = document.getElementById('content');
        const angleInput = document.getElementById('ai-angle');
        const toneInput = document.getElementById('ai-tone');
        const lengthInput = document.getElementById('ai-length');

        function clean(value) {
            return (value || '').trim();
        }

        function articleContext() {
            const title = clean(titleInput.value) || 'Sujet a traiter';
            const angle = clean(angleInput.value) || 'les enjeux sociaux, humains et institutionnels';
            const tone = clean(toneInput.value) || 'professionnel';
            const length = clean(lengthInput.value) || 'standard';
            return { title, angle, tone, length };
        }

        function insertAtCursor(text) {
            const start = contentInput.selectionStart;
            const end = contentInput.selectionEnd;
            const current = contentInput.value;
            const prefix = current.slice(0, start);
            const suffix = current.slice(end);
            const spacerBefore = prefix && !prefix.endsWith('\n') ? '\n\n' : '';
            const spacerAfter = suffix && !text.endsWith('\n') ? '\n\n' : '';
            contentInput.value = `${prefix}${spacerBefore}${text}${spacerAfter}${suffix}`;
            contentInput.focus();
            contentInput.selectionStart = contentInput.selectionEnd = (prefix + spacerBefore + text).length;
        }

        function replaceSelection(text) {
            const start = contentInput.selectionStart;
            const end = contentInput.selectionEnd;
            if (start === end) {
                insertAtCursor(text);
                return;
            }
            contentInput.setRangeText(text, start, end, 'end');
            contentInput.focus();
        }

        async function generateText(action) {
            const { title, angle, tone, length } = articleContext();
            const selectedText = contentInput.value.slice(contentInput.selectionStart, contentInput.selectionEnd).trim();
            const depth = {
                court: 'avec une analyse concise, directe et facile a lire',
                standard: 'avec une analyse developpee, structuree et accessible',
                long: 'avec une analyse approfondie, des nuances, des exemples et une ouverture forte'
            }[length] || 'avec une analyse developpee, structuree et accessible';

            const templates = {
                full: `# ${title}\n\n## Introduction\nDans un contexte ou ${angle} occupent une place importante dans le debat public, ${title.toLowerCase()} merite une lecture attentive. Cet article propose une approche ${tone}, ${depth}, afin de depasser la simple observation des faits et de comprendre ce qu'ils revelent de la societe.\n\n## Comprendre le contexte\nLe sujet s'inscrit dans un ensemble de dynamiques sociales qui touchent a la fois les individus, les institutions et les communautes. Pour en saisir la portee, il faut replacer les faits dans leur environnement: les conditions de vie, les rapports de pouvoir, les representations collectives et les attentes des populations concernees.\n\nCette premiere lecture permet d'eviter les jugements rapides. Elle rappelle qu'un phenomene social n'apparait jamais seul: il est souvent le resultat d'une histoire, de contraintes structurelles et de choix publics qui influencent les comportements.\n\n## Les causes profondes\nDerriere ${title.toLowerCase()}, plusieurs questions se croisent. Il y a d'abord la question des inegalites: qui a acces aux ressources, a la parole, a la reconnaissance et a la protection? Il y a ensuite la question de la confiance: comment les citoyens percoivent-ils les institutions, les medias ou les acteurs sociaux qui interviennent dans leur quotidien?\n\nL'analyse sociologique aide ici a rendre visibles les mecanismes moins apparents. Elle montre que les situations individuelles sont souvent liees a des organisations collectives, a des normes sociales et a des rapports economiques ou culturels plus larges.\n\n## Les consequences humaines\nLes effets de ce sujet se lisent dans les parcours de vie. Ils peuvent modifier la maniere dont les personnes se projettent, participent a la vie publique, accedent a leurs droits ou construisent leur dignite. C'est pourquoi l'analyse ne doit pas seulement compter les faits: elle doit aussi ecouter les experiences.\n\nMettre l'humain au centre permet de comprendre ce que les chiffres, les discours officiels ou les reactions mediatiques ne disent pas toujours. Cette attention aux vecus donne plus de justesse a l'interpretation et ouvre la voie a des reponses plus adaptees.\n\n## Quelles pistes d'action?\nPour avancer, il est necessaire de construire des espaces de dialogue plus ouverts, de renforcer l'information de qualite et de soutenir les initiatives capables de rapprocher les institutions des realites du terrain. Les solutions doivent etre pensees avec les personnes concernees, et non uniquement pour elles.\n\nUne approche responsable suppose aussi de mieux communiquer: expliquer les enjeux, rendre les donnees comprehensibles, valoriser les temoignages et favoriser une culture du debat public fondee sur le respect et la nuance.\n\n## Conclusion\n${title} n'est pas seulement un sujet d'actualite ou d'opinion. C'est un point d'entree pour interroger notre maniere de vivre ensemble, de proteger les droits, de reconnaitre les experiences et de construire des reponses collectives. En allant au-dela des faits, l'objectif est de produire une lecture utile, humaine et engagee, capable d'ouvrir la discussion plutot que de la fermer.`,
                plan: `## ${title}\n\n### Introduction\nPresenter le sujet, son contexte et l'interet public de l'analyse.\n\n### 1. Comprendre le contexte\nExpliquer les faits, les acteurs concernes et les tensions visibles autour de ${angle}.\n\n### 2. Lire les causes profondes\nAnalyser les dynamiques sociales, culturelles, economiques ou institutionnelles qui structurent la situation.\n\n### 3. Montrer les consequences humaines\nMettre en avant les effets concrets sur les populations, les parcours de vie et la dignite.\n\n### 4. Ouvrir des pistes d'action\nProposer des leviers de dialogue, de prevention, de politique publique ou de mobilisation citoyenne.\n\n### Conclusion\nRevenir a l'enjeu central et ouvrir sur une question forte pour inviter les lecteurs a reagir.`,
                intro: `Dans un contexte ou ${angle} occupent une place importante dans le debat public, ${title.toLowerCase()} merite une lecture attentive. Au-dela des faits immediats, cette analyse propose de comprendre les dynamiques sociales qui traversent le sujet, avec un regard ${tone}, clair et accessible.`,
                conclusion: `En definitive, ${title.toLowerCase()} rappelle qu'un fait social ne se limite jamais a sa surface. Il engage des parcours, des responsabilites collectives et des choix publics. L'enjeu est donc de continuer a questionner, documenter et ouvrir des espaces de dialogue utiles autour de ${angle}.`,
                improve: selectedText
                    ? `Cette idee gagne a etre lue dans toute sa complexite. Elle invite a relier l'experience vecue, les structures sociales et les responsabilites institutionnelles, afin de produire une analyse plus nuancee, plus humaine et plus utile au debat public.`
                    : `Aucun passage selectionne.`
            };

            try {
                const response = await fetch('{{ route('admin.posts.ai-draft') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        title,
                        angle,
                        tone,
                        length,
                        action,
                        selection: selectedText,
                    }),
                });
                const data = await response.json();
                return data.content || templates[action] || templates.plan;
            } catch (error) {
                return templates[action] || templates.plan;
            }
        }

        document.querySelectorAll('.ai-tool').forEach((button) => {
            button.addEventListener('click', async () => {
                const action = button.dataset.aiAction;
                const previousText = button.textContent;
                button.disabled = true;
                button.textContent = 'Generation...';
                const generated = await generateText(action);
                button.disabled = false;
                button.textContent = previousText;
                if (action === 'improve') {
                    replaceSelection(generated);
                    return;
                }
                if (action === 'full' && (!contentInput.value.trim() || confirm('Le contenu actuel sera remplace par un article complet genere. Continuer ?'))) {
                    contentInput.value = generated;
                    contentInput.focus();
                    return;
                }
                insertAtCursor(generated);
            });
        });
    })();
</script>
