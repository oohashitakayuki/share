<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
    private $auth;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(config('services.firebase.credentials'));

        $this->auth = $factory->createAuth();
    }

    public function verifyIdToken($token)
    {
        return $this->auth->verifyIdToken($token);
    }
}
