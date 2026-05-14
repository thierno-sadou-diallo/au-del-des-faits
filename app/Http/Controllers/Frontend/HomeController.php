<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessage;
use App\Models\Category;
use App\Models\Comment;
use App\Models\NewsletterSubscriber;
use App\Models\Portfolio;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        if (! $this->contentTablesAreReady()) {
            return view('frontend.home', [
                'recentPosts' => collect(),
                'featuredProjects' => collect(),
                'popularPosts' => collect(),
                'popularProjects' => collect(),
                'stats' => [
                    'posts' => 0,
                    'projects' => 0,
                    'media' => 0,
                    'comments' => 0,
                    'subscribers' => 0,
                    'likes' => 0,
                ],
                'seoTitle' => 'Au-delà des faits - Blog sociologique et médias',
                'seoDescription' => 'Analyses sociologiques, droits humains, justice sociale et médias par Halimatou Keita.',
            ]);
        }

        $recentPosts = Cache::remember('home_recent_posts', 300, function () {
            return Post::query()->with('category')->where('status', 'published')->latest()->take(3)->get();
        });

        $featuredProjects = Cache::remember('home_featured_projects', 300, function () {
            return Portfolio::query()->with('category')->latest()->take(3)->get();
        });

        $popularPosts = Cache::remember('home_popular_posts', 300, function () {
            return Post::query()->where('status', 'published')->orderByDesc('views')->take(3)->get();
        });

        $popularProjects = Cache::remember('home_popular_projects', 300, function () {
            return Portfolio::query()->orderByDesc('views')->take(3)->get();
        });

        $stats = Cache::remember('home_stats', 300, function () {
            return [
                'posts' => Post::query()->where('status', 'published')->count(),
                'projects' => Portfolio::query()->count(),
                'media' => Portfolio::query()->whereHas('category', fn ($q) => $q->where('type', 'media'))->count(),
                'comments' => Comment::query()->where('is_approved', true)->count(),
                'subscribers' => NewsletterSubscriber::query()->count(),
                'likes' => Post::query()->sum('likes') + Portfolio::query()->sum('likes'),
            ];
        });

        return view('frontend.home', [
            'recentPosts' => $recentPosts,
            'featuredProjects' => $featuredProjects,
            'popularPosts' => $popularPosts,
            'popularProjects' => $popularProjects,
            'stats' => $stats,
            'seoTitle' => 'Au-delà des faits - Blog sociologique et médias',
            'seoDescription' => 'Blog sociologique de Halimatou Keita consacré à la justice sociale, aux droits humains, au Sénégal, à l’Afrique et aux médias.',
        ]);
    }

    public function about()
    {
        return view('frontend.about', [
            'seoTitle' => 'À propos - Au-delà des faits',
            'seoDescription' => 'Découvrez Halimatou Keita et sa mission sociologique.',
        ]);
    }

    public function thematiques()
    {
        $categories = Cache::remember('categories', 3600, function () {
            return Category::all();
        });

        return view('frontend.thematiques', [
            'categories' => $categories,
            'seoTitle' => 'Thématiques - Au-delà des faits',
            'seoDescription' => 'Explorez les différentes thématiques sociologiques abordées.',
        ]);
    }

    public function medias()
    {
        $categoryId = request('category');
        $mediaItems = Portfolio::query()
            ->with('category')
            ->whereHas('category', fn ($q) => $q->where('type', 'media'))
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $categories = Cache::remember('media_categories', 600, function () {
            return Category::query()->where('type', 'media')->orderBy('name')->get();
        });

        return view('frontend.medias', [
            'mediaItems' => $mediaItems,
            'categories' => $categories,
            'seoTitle' => 'Médias - Au-delà des faits',
            'seoDescription' => 'Découvrez les apparitions médiatiques, vidéos, interviews et interventions.',
        ]);
    }

    public function services()
    {
        return view('frontend.services', [
            'seoTitle' => 'Services - Au-delà des faits',
            'seoDescription' => 'Découvrez les services de conseil, communication et accompagnement sociologique.',
        ]);
    }

    public function contact()
    {
        return view('frontend.contact', [
            'seoTitle' => 'Contact - Au-delà des faits',
            'seoDescription' => 'Contactez Halimatou Keita pour vos projets sociologiques.',
        ]);
    }

    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'organization' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'newsletter' => 'nullable|boolean',
        ]);

        Mail::to('halimatouk484@gmail.com')->send(new ContactMessage($validated));

        if ($request->newsletter) {
            NewsletterSubscriber::firstOrCreate(
                ['email' => $validated['email']],
                ['name' => $validated['name']]
            );
        }

        return back()->with('status', 'Votre message a été envoyé avec succès. Je vous répondrai dans les plus brefs délais.');
    }

    private function contentTablesAreReady(): bool
    {
        if (DB::getDriverName() !== 'sqlite') {
            return true;
        }

        return Schema::hasTable('posts') && Schema::hasTable('portfolios');
    }
}
