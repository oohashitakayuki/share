<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\FirebaseService;
use Closure;
use Illuminate\Support\Facades\Auth;

class FirebaseAuth
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message'=>'Unauthenticated'],401);
        }

        $firebase = app(FirebaseService::class);

        $verifiedIdToken = $firebase->verifyIdToken($token);
        $uid = $verifiedIdToken->claims()->get('sub');

        $user = User::where('firebase_uid',$uid)->first();

        if (!$user) {
            return response()->json(['message'=>'User not found'],401);
        }

        Auth::login($user);

        return $next($request);
    }
}
