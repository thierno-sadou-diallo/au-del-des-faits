<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
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
        $publicationTrend = collect(range(5, 0))->map(function (int $monthsAgo) {
            $month = now()->subMonths($monthsAgo);

            return [
                'label' => $month->format('M y'),
                'count' => Post::where('status', 'published')
                    ->whereBetween('created_at', [
                        $month->copy()->startOfMonth(),
                        $month->copy()->endOfMonth(),
                    ])
                    ->count(),
            ];
        });

        $publishedByCategory = Post::with('category')
            ->where('status', 'published')
            ->get()
            ->groupBy(fn ($post) => $post->category?->name ?? 'Sans categorie')
            ->map(fn ($items, $label) => [
                'label' => $label,
                'count' => $items->count(),
            ])
            ->sortByDesc('count')
            ->take(5)
            ->values();

        return view('admin.dashboard', [
            'postsCount' => Post::count(),
            'publishedPostsCount' => Post::where('status', 'published')->count(),
            'draftPostsCount' => Post::where('status', 'draft')->count(),
            'projectsCount' => Portfolio::count(),
            'mediaCount' => Portfolio::whereHas('category', fn ($query) => $query->where('type', 'media'))->count(),
            'pendingCommentsCount' => Comment::where('is_approved', false)->count(),
            'approvedCommentsCount' => Comment::where('is_approved', true)->count(),
            'subscribersCount' => NewsletterSubscriber::count(),
            'pendingAppointmentsCount' => Appointment::where('status', 'pending')->count(),
            'confirmedAppointmentsCount' => Appointment::where('status', 'confirmed')->count(),
            'availableSlotsCount' => AvailabilitySlot::where('is_available', true)
                ->whereColumn('current_appointments', '<', 'max_appointments')
                ->count(),
            'latestAppointments' => Appointment::with('availabilitySlot')->latest()->take(5)->get(),
            'publicationTrend' => $publicationTrend,
            'publishedByCategory' => $publishedByCategory,
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
