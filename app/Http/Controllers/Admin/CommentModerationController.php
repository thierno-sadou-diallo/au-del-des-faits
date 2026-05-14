<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentModerationController extends Controller
{
    public function index()
    {
        return view('admin.comments.index', [
            'comments' => Comment::query()
                ->with([
                    'post',
                    'commentable',
                    'replies' => fn ($query) => $query->oldest(),
                ])
                ->whereNull('parent_id')
                ->latest()
                ->paginate(20),
        ]);
    }

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        return back()->with('status', 'Commentaire approuve.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('status', 'Commentaire supprime.');
    }

    public function reply(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $comment->replies()->create([
            'post_id' => $comment->post_id,
            'commentable_type' => $comment->commentable_type,
            'commentable_id' => $comment->commentable_id,
            'parent_id' => $comment->id,
            'name' => $validated['name'] ?: auth()->user()->name,
            'email' => auth()->user()->email,
            'message' => $validated['message'],
            'is_approved' => true,
        ]);

        return back()->with('status', 'Réponse publiée.');
    }
}
