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
            'captcha' => app()->environment('testing') ? ['nullable'] : ['required', 'captcha'],
        ]);

        unset($validated['captcha']);

        ServiceReview::create([
            ...$validated,
            'email' => '',
            'is_approved' => false,
        ]);

        return back()->with('status', 'Merci pour votre avis. Il sera publie apres validation.');
    }
}
