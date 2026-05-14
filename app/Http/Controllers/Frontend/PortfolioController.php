<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Cache;

class PortfolioController extends Controller
{
    public function index()
    {
        $categoryId = request('category');
        $projects = Portfolio::query()
            ->with('category')
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->latest()
            ->paginate(9)
            ->withQueryString();
        $categories = Cache::remember('portfolio_categories', 600, function () {
            return Category::query()->where('type', 'portfolio')->orderBy('name')->get();
        });

        return view('portfolio.index', [
            'projects' => $projects,
            'categories' => $categories,
            'seoTitle' => 'Médias et réalisations - Au-delà des faits',
            'seoDescription' => 'Découvrez les vidéos, interventions, projets et réalisations de Au-delà des faits.',
        ]);
    }

    public function like(Portfolio $portfolio)
    {
        $portfolio->increment('likes');

        return back()->with('status', 'Merci pour votre soutien.');
    }

    public function show(Portfolio $portfolio)
    {
        $portfolio->increment('views');

        $similarProjects = Cache::remember("portfolio_similar_{$portfolio->id}", 300, function () use ($portfolio) {
            return Portfolio::query()
                ->where('id', '!=', $portfolio->id)
                ->where('category_id', $portfolio->category_id)
                ->latest()
                ->take(3)
                ->get();
        });

        return view('portfolio.show', [
            'project' => $portfolio->load('category'),
            'similarProjects' => $similarProjects,
            'seoTitle' => $portfolio->title.' - Au-delà des faits',
            'seoDescription' => str($portfolio->description)->limit(160)->toString(),
            'seoImage' => ! empty($portfolio->images[0]) ? asset('storage/'.$portfolio->images[0]) : asset('images/logo.PNG'),
        ]);
    }
}
