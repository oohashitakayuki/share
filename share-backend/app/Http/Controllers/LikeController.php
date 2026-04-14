<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        Like::firstOrCreate([
            'user_id' => $user->id,
            'post_id' => $request->post_id
        ]);

        return response()->json(['message' => 'liked']);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        Like::where('user_id', $user->id)
            ->where('post_id', $request->post_id)
            ->delete();

        return response()->json(['message' => 'unliked']);
    }
}
