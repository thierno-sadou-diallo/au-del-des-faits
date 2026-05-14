<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\NewsletterSubscriber;
use App\Models\Portfolio;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $postsViews = Post::sum('views');
        $mediaViews = Portfolio::sum('views');
        $postsLikes = Post::sum('likes');
        $mediaLikes = Portfolio::sum('likes');

        return view('admin.dashboard', [
            'postsCount' => Post::count(),
            'publishedPostsCount' => Post::where('status', 'published')->count(),
            'draftPostsCount' => Post::where('status', 'draft')->count(),
            'projectsCount' => Portfolio::count(),
            'mediaCount' => Portfolio::whereHas('category', fn ($query) => $query->where('type', 'media'))->count(),
            'pendingCommentsCount' => Comment::where('is_approved', false)->count(),
            'approvedCommentsCount' => Comment::where('is_approved', true)->count(),
            'subscribersCount' => NewsletterSubscriber::count(),
            'totalViews' => $postsViews + $mediaViews,
            'totalLikes' => $postsLikes + $mediaLikes,
            'latestPosts' => Post::with('category')->latest()->take(5)->get(),
            'latestMedia' => Portfolio::with('category')
                ->whereHas('category', fn ($query) => $query->where('type', 'media'))
                ->latest()
                ->take(5)
                ->get(),
            'topPosts' => Post::with('category')->orderByDesc('views')->take(5)->get(),
        ]);
    }
}
