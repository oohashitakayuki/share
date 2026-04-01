<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request, FirebaseService $firebase)
    {
        $token = $request->bearerToken();

        $verifiedIdToken = $firebase->verifyIdToken($token);

        $uid = $verifiedIdToken->claims()->get('sub');

        $user = User::updateOrCreate(
            ['firebase_uid' => $uid],
            [
                'name'=>$request->name,
                'email'=>$request->email
            ]
        );

        return response()->json($user);
    }

    public function login(Request $request, FirebaseService $firebase)
    {
        $token = $request->bearerToken();

        $verifiedIdToken = $firebase->verifyIdToken($token);

        $uid = $verifiedIdToken->claims()->get('sub');

        $user = User::where('firebase_uid',$uid)->first();

        return response()->json($user);
    }
}
