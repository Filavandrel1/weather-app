<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);
        $comment = Comment::create([
            'content' => $request->content,
            'user_id' => auth()->user()->id,
            'post_id' => $request->post_id,
        ]);
        return redirect()->route('weather.show', $request->post_id);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        if (!Gate::allows('delete', $comment)) {
            return redirect()->back();
        }
        $comment->delete();
        return redirect()->back();
    }
}
