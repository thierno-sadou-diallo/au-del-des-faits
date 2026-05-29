<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceReview;
use Illuminate\Http\Request;

class ServiceReviewController extends Controller
{
    public function index()
    {
        $status = request('status', 'all');
        $reviewsQuery = ServiceReview::query()->latest();

        match ($status) {
            'pending' => $reviewsQuery->where('is_approved', false),
            'answered' => $reviewsQuery->whereNotNull('admin_reply'),
            'unanswered' => $reviewsQuery->whereNull('admin_reply'),
            default => null,
        };

        return view('admin.service-reviews.index', [
            'reviews' => $reviewsQuery->paginate(12)->withQueryString(),
            'status' => $status,
            'reviewStats' => [
                'total' => ServiceReview::count(),
                'pending' => ServiceReview::where('is_approved', false)->count(),
                'answered' => ServiceReview::whereNotNull('admin_reply')->count(),
                'unanswered' => ServiceReview::whereNull('admin_reply')->count(),
            ],
        ]);
    }

    public function approve(ServiceReview $serviceReview)
    {
        $serviceReview->update(['is_approved' => true]);

        return back()->with('status', 'Avis approuvé.');
    }

    public function reply(Request $request, ServiceReview $serviceReview)
    {
        $validated = $request->validate([
            'admin_reply_author' => ['nullable', 'string', 'max:120'],
            'admin_reply' => ['required', 'string', 'max:2000'],
        ]);

        $serviceReview->update([
            'admin_reply' => $validated['admin_reply'],
            'admin_reply_author' => $validated['admin_reply_author'] ?: 'Au-delà des faits',
            'replied_at' => now(),
            'is_approved' => true,
        ]);

        return back()->with('status', 'Réponse publiée sous l’avis.');
    }

    public function destroy(ServiceReview $serviceReview)
    {
        $serviceReview->delete();

        return back()->with('status', 'Avis supprimé.');
    }
}
