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
            ->withCount('likes') // ← いいね数
            ->latest()
            ->get()
            ->map(function ($post) use ($user) {
                $post->is_liked = $user->is_like($post->id); // ← いいね済みか
                return $post;
            });

    return response()->json($posts);
    }

    public function show($id)
    {
        $user = Auth::user();

        $post = Post::with('user')
            ->withCount('likes')
            ->findOrFail($id);

        $post->is_liked = $user->is_like($post->id);

        return response()->json($post);
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
