<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
            'captcha' => ['required', 'captcha'],
        ]);

        $post->comments()->create($validated + ['is_approved' => false]);

        return back()->with('status', 'Commentaire envoye. Il sera publie apres moderation.');
    }

    public function storePortfolioComment(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
            'captcha' => ['required', 'captcha'],
        ]);

        $portfolio->comments()->create($validated + [
            'is_approved' => false,
            'commentable_type' => Portfolio::class,
            'commentable_id' => $portfolio->id,
        ]);

        return back()->with('status', 'Commentaire envoye. Il sera publie apres moderation.');
    }
}
