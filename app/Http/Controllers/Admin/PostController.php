<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        return view('admin.blog.index', [
            'posts' => Post::with('category')->latest()->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.blog.create', [
            'categories' => Category::query()->where('type', 'blog')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
        $data['slug'] = Str::slug($data['title']).'-'.Str::random(6);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }
        Post::create($data);
        $this->clearPublicCaches();

        return redirect()->route('admin.posts.index')->with('status', 'Article cree.');
    }

    public function edit(Post $post)
    {
        return view('admin.blog.edit', [
            'post' => $post,
            'categories' => Category::query()->where('type', 'blog')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }
        $data['slug'] = Str::slug($data['title']).'-'.Str::random(6);
        $post->update($data);
        $this->clearPublicCaches($post);

        return redirect()->route('admin.posts.index')->with('status', 'Article mis a jour.');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        $this->clearPublicCaches($post);

        return back()->with('status', 'Article supprime.');
    }

    public function aiDraft(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'angle' => ['nullable', 'string', 'max:255'],
            'tone' => ['nullable', 'string', 'max:80'],
            'length' => ['nullable', 'in:court,standard,long'],
            'action' => ['required', 'in:full,plan,intro,conclusion,improve'],
            'selection' => ['nullable', 'string'],
        ]);

        $generated = null;
        if (filled(env('OPENAI_API_KEY'))) {
            try {
                $generated = $this->generateWithAi($data);
            } catch (\Throwable) {
                $generated = null;
            }
        }

        return response()->json([
            'content' => $generated ?: $this->generateLocalDraft($data),
            'source' => $generated ? 'ai' : 'local',
        ]);
    }

    private function clearPublicCaches(?Post $post = null): void
    {
        Cache::forget('blog_recent_posts');
        Cache::forget('home_recent_posts');
        Cache::forget('home_popular_posts');
        Cache::forget('home_stats');

        if ($post) {
            Cache::forget("post_similar_{$post->id}");
        }
    }

    private function generateWithAi(array $data): ?string
    {
        $lengths = [
            'court' => 'un article court de 500 a 700 mots',
            'standard' => 'un article complet de 900 a 1200 mots',
            'long' => 'un article approfondi de 1400 a 1800 mots',
        ];

        $actionInstructions = [
            'full' => $lengths[$data['length'] ?? 'standard'] ?? $lengths['standard'],
            'plan' => 'un plan detaille avec titres et sous-parties',
            'intro' => 'une introduction forte et professionnelle',
            'conclusion' => 'une conclusion claire avec ouverture',
            'improve' => 'une reformulation plus professionnelle du texte selectionne',
        ];

        $prompt = "Titre: {$data['title']}\n"
            .'Angle: '.($data['angle'] ?? 'enjeux sociaux, africains et humains')."\n"
            .'Ton: '.($data['tone'] ?? 'professionnel')."\n"
            .'Demande: '.$actionInstructions[$data['action']]."\n"
            .'Texte selectionne: '.($data['selection'] ?? '')."\n\n"
            .'Redige en francais, avec une voix editoriale professionnelle, claire, sensible et adaptee a un blog sociologique africain. Utilise des titres Markdown. Retourne uniquement le contenu publiable de l article. Ne t adresse pas a l administrateur, ne donne pas de conseils d utilisation, ne mentionne pas que tu es une IA.';

        $response = Http::withToken(env('OPENAI_API_KEY'))
            ->timeout(60)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
                'messages' => [
                    ['role' => 'system', 'content' => 'Tu es un assistant editorial senior pour un blog sociologique africain professionnel.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
            ]);

        if (! $response->successful()) {
            return null;
        }

        return trim($response->json('choices.0.message.content', '')) ?: null;
    }

    private function generateLocalDraft(array $data): string
    {
        $title = $data['title'];
        $angle = $data['angle'] ?: 'les enjeux sociaux, humains et institutionnels';
        $tone = $data['tone'] ?: 'professionnel';
        $selection = trim($data['selection'] ?? '');

        return match ($data['action']) {
            'plan' => "## {$title}\n\n### Introduction\nPresenter le sujet, son contexte et l'interet public.\n\n### 1. Comprendre le contexte\nExpliquer les faits et les acteurs concernes autour de {$angle}.\n\n### 2. Lire les causes profondes\nAnalyser les dynamiques sociales, culturelles ou institutionnelles.\n\n### 3. Montrer les consequences humaines\nMettre en avant les effets concrets sur les populations.\n\n### 4. Ouvrir des pistes d'action\nProposer des leviers de dialogue et d'action.\n\n### Conclusion\nRevenir a l'enjeu central et ouvrir le debat.",
            'intro' => "Dans un contexte ou {$angle} occupent une place importante dans le debat public, {$title} merite une lecture attentive. Cet article propose une approche {$tone}, claire et accessible, afin de depasser la simple observation des faits.",
            'conclusion' => "En definitive, {$title} rappelle qu'un fait social ne se limite jamais a sa surface. Il engage des parcours, des responsabilites collectives et des choix publics. L'enjeu est donc de continuer a questionner, documenter et ouvrir des espaces de dialogue utiles.",
            'improve' => $selection
                ? "Cette idee gagne a etre lue dans toute sa complexite. Elle relie l'experience vecue, les structures sociales et les responsabilites institutionnelles afin de produire une analyse plus nuancee et plus utile au debat public."
                : "Aucun passage selectionne.",
            default => "# {$title}\n\n## Introduction\nDans un contexte ou {$angle} occupent une place importante dans le debat public, {$title} merite une lecture attentive. Cet article propose une approche {$tone}, afin de depasser la simple observation des faits et de comprendre ce qu'ils revelent de la societe.\n\n## Comprendre le contexte\nLe sujet s'inscrit dans un ensemble de dynamiques sociales qui touchent les individus, les institutions et les communautes. Pour en saisir la portee, il faut replacer les faits dans leur environnement: conditions de vie, rapports de pouvoir, representations collectives et attentes des populations.\n\n## Les causes profondes\nDerriere {$title}, plusieurs questions se croisent: l'acces aux ressources, la parole publique, la reconnaissance, la confiance envers les institutions et la maniere dont les medias racontent les realites sociales.\n\n## Les consequences humaines\nLes effets se lisent dans les parcours de vie. Ils peuvent modifier la maniere dont les personnes se projettent, participent a la vie publique, accedent a leurs droits ou construisent leur dignite.\n\n## Quelles pistes d'action?\nPour avancer, il faut construire des espaces de dialogue plus ouverts, renforcer l'information de qualite et soutenir les initiatives capables de rapprocher les institutions des realites du terrain.\n\n## Conclusion\n{$title} n'est pas seulement un sujet d'actualite. C'est une invitation a interroger notre maniere de vivre ensemble, de proteger les droits et de construire des reponses collectives plus justes.",
        };
    }
}
