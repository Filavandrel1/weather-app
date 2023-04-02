<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(CommentRequest $request): RedirectResponse
    {
        $comment = Comment::create([
            'content' => $request->content,
            'user_id' => auth()->user()->id,
            'post_id' => $request->post_id,
        ]);
        return redirect()->route('weather.show', $request->post_id);
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        if (!Gate::allows('delete', $comment)) {
            return redirect()->back();
        }
        $comment->delete();
        return redirect()->back();
    }
}
