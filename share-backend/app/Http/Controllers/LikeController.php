<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store($postId)
    {
        $user = Auth::user();

        if (!$user->is_like($postId)) {
            $user->likes()->create([
                'post_id' => $postId,
            ]);
        }

        return response()->json(['message' => 'liked']);
    }

    public function destroy($postId)
    {
        $user = Auth::user();

        $like = Like::where('post_id', $postId)
            ->where('user_id', $user->id)
            ->first();

        if($like) {
            $like->delete();
        }

        return response()->json(['message' => 'unliked']);
    }
}
