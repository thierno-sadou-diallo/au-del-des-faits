<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ServiceReview;
use Illuminate\Http\Request;

class ServiceReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'organization' => 'nullable|string|max:160',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|min:10|max:1200',
        ]);

        ServiceReview::create([
            ...$validated,
            'email' => '',
            'is_approved' => true,
        ]);

        return back()->with('status', 'Merci pour votre avis. Il est maintenant visible dans l espace services.');
    }
}
