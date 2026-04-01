<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $post = Post::create([
            'user_id' => $user->id,
            'post' => $request->post
        ]);

        return response()->json($post->load('user'));
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $post = Post::findOrFail($id);

        // 自分の投稿のみ削除可能にする
        if ($post->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
