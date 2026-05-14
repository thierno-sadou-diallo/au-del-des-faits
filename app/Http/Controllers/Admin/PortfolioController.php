<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index()
    {
        return view('admin.portfolio.index', [
            'projects' => Portfolio::with('category')->latest()->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.portfolio.create', [
            'categories' => Category::query()->orderBy('type')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['title']).'-'.Str::random(6);
        Portfolio::create($data);
        $this->clearPublicCaches();

        return redirect()->route('admin.portfolios.index')->with('status', 'Projet cree.');
    }

    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolio.edit', [
            'project' => $portfolio,
            'categories' => Category::query()->orderBy('type')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['title']).'-'.Str::random(6);
        if (! empty($data['images'])) {
            foreach ($portfolio->images ?? [] as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        } else {
            $data['images'] = $portfolio->images ?? [];
        }
        $portfolio->update($data);
        $this->clearPublicCaches($portfolio);

        return redirect()->route('admin.portfolios.index')->with('status', 'Projet mis a jour.');
    }

    public function destroy(Portfolio $portfolio)
    {
        foreach ($portfolio->images ?? [] as $image) {
            Storage::disk('public')->delete($image);
        }
        $portfolio->delete();
        $this->clearPublicCaches($portfolio);

        return back()->with('status', 'Projet supprime.');
    }

    protected function validateData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'link' => ['nullable', 'url'],
            'video_url' => ['nullable', 'url'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'technologies' => ['nullable', 'string'],
            'images.*' => ['nullable', 'image', 'max:2048'],
        ]);
        $data['technologies'] = ! empty($data['technologies'])
            ? array_values(array_filter(array_map('trim', explode(',', $data['technologies']))))
            : [];
        $data['images'] = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $data['images'][] = $image->store('portfolio', 'public');
            }
        }
        return $data;
    }

    private function clearPublicCaches(?Portfolio $portfolio = null): void
    {
        Cache::forget('home_featured_projects');
        Cache::forget('home_popular_projects');
        Cache::forget('home_stats');
        Cache::forget('portfolio_categories');
        Cache::forget('media_categories');

        if ($portfolio) {
            Cache::forget("portfolio_similar_{$portfolio->id}");
        }
    }
}
