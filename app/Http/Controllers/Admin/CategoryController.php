<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::query()->latest()->paginate(20),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:blog,portfolio,media'],
        ]);
        Category::create($data);
        $this->clearPublicCaches();

        return back()->with('status', 'Categorie creee.');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:blog,portfolio,media'],
        ]);
        $category->update($data);
        $this->clearPublicCaches();

        return back()->with('status', 'Categorie mise a jour.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        $this->clearPublicCaches();

        return back()->with('status', 'Categorie supprimee.');
    }

    private function clearPublicCaches(): void
    {
        Cache::forget('categories');
        Cache::forget('portfolio_categories');
        Cache::forget('media_categories');
        Cache::forget('home_stats');
    }
}
