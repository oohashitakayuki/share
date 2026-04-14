<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $posts = Post::with('user')
            ->withCount('likes')
            ->get()
            ->map(function ($post) use ($user) {
                $post->is_liked = $post->likes()
                    ->where('user_id', $user->id)
                    ->exists();
                return $post;
            });

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
