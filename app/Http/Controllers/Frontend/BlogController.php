<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->with('category')
            ->where('status', 'published')
            ->latest()
            ->paginate(6)
            ->withQueryString();
        $recentPosts = Cache::remember('blog_recent_posts', 300, function () {
            return Post::query()->where('status', 'published')->latest()->take(4)->get();
        });

        return view('blog.index', [
            'posts' => $posts,
            'recentPosts' => $recentPosts,
            'seoTitle' => 'Articles - Au-delà des faits',
            'seoDescription' => 'Analyses sociologiques sur la justice sociale, les droits humains, le Sénégal, l’Afrique et les médias.',
        ]);
    }

    public function show(Post $post)
    {
        abort_if($post->status !== 'published', 404);

        $post->increment('views');
        $post->load(['category']);
        $post->load([
            'category',
            'comments' => fn ($q) => $q
                ->where('is_approved', true)
                ->whereNull('parent_id')
                ->with(['replies' => fn ($rq) => $rq->where('is_approved', true)]),
        ]);

        $similarPosts = Cache::remember("post_similar_{$post->id}", 300, function () use ($post) {
            return Post::query()
                ->where('id', '!=', $post->id)
                ->where('status', 'published')
                ->where('category_id', $post->category_id)
                ->latest()
                ->take(3)
                ->get();
        });

        return view('blog.show', [
            'post' => $post,
            'similarPosts' => $similarPosts,
            'recentPosts' => Cache::remember('blog_recent_posts', 300, function () {
                return Post::query()->where('status', 'published')->latest()->take(4)->get();
            }),
            'seoTitle' => $post->title.' - Au-delà des faits',
            'seoDescription' => str($post->excerpt)->limit(160)->toString(),
            'seoImage' => $post->image_url ?: asset('images/logo.PNG'),
        ]);
    }

    public function like(Post $post)
    {
        $post->increment('likes');

        return back()->with('status', 'Merci, vous avez aime cet article.');
    }

    public function translate(Post $post)
    {
        abort_if($post->status !== 'published', 404);

        $language = request('language', 'en');
        $languages = [
            'en' => 'anglais',
            'wo' => 'wolof',
            'es' => 'espagnol',
        ];

        abort_if(! array_key_exists($language, $languages), 422);

        $cacheKey = "post_translation_v2_{$post->id}_{$language}";
        $translated = Cache::remember($cacheKey, 3600, function () use ($post, $languages, $language) {
            $source = trim($post->title."\n\n".str($post->content)->stripTags()->squish()->toString());

            if (filled(env('OPENAI_API_KEY'))) {
                try {
                    $response = Http::withToken(env('OPENAI_API_KEY'))
                        ->timeout(45)
                        ->post('https://api.openai.com/v1/chat/completions', [
                            'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
                            'messages' => [
                                [
                                    'role' => 'system',
                                    'content' => 'Tu es un traducteur professionnel. Traduis fidelement le texte fourni. Conserve les paragraphes et le sens editorial. Ne rajoute aucun commentaire.',
                                ],
                                [
                                    'role' => 'user',
                                    'content' => "Traduis ce texte en {$languages[$language]}:\n\n{$source}",
                                ],
                            ],
                            'temperature' => 0.2,
                        ]);

                    if ($response->successful()) {
                        return trim($response->json('choices.0.message.content', ''));
                    }
                } catch (\Throwable) {
                    // Fallback below keeps the public feature graceful if the AI service is unavailable.
                }
            }

            return $this->translateWithGoogleFallback($source, $language)
                ?: "La traduction automatique est temporairement indisponible. Texte original:\n\n{$source}";
        });

        return response()->json([
            'language' => $languages[$language],
            'translation' => $translated,
        ]);
    }

    private function translateWithGoogleFallback(string $source, string $language): ?string
    {
        try {
            $chunks = str($source)
                ->split('/(?<=[.!?])\s+/')
                ->reduce(function (array $chunks, string $sentence) {
                    $lastIndex = count($chunks) - 1;
                    if ($lastIndex >= 0 && strlen($chunks[$lastIndex].' '.$sentence) < 4200) {
                        $chunks[$lastIndex] .= ' '.$sentence;
                    } else {
                        $chunks[] = $sentence;
                    }

                    return $chunks;
                }, []);

            $translatedChunks = [];
            foreach ($chunks as $chunk) {
                $response = Http::timeout(20)->get('https://translate.googleapis.com/translate_a/single', [
                    'client' => 'gtx',
                    'sl' => 'fr',
                    'tl' => $language,
                    'dt' => 't',
                    'q' => $chunk,
                ]);

                if (! $response->successful()) {
                    return null;
                }

                $payload = $response->json();
                $translatedChunks[] = collect($payload[0] ?? [])
                    ->map(fn ($line) => $line[0] ?? '')
                    ->implode('');
            }

            return trim(implode("\n\n", array_filter($translatedChunks))) ?: null;
        } catch (\Throwable) {
            return null;
        }
    }
}
