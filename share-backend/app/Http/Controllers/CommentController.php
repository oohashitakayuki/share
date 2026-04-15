<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $comment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $request->post_id,
            'comment' => $request->comment,
        ]);

        // ユーザー情報も返す
        $comment->load('user');

        return response()->json($comment);
    }
}
