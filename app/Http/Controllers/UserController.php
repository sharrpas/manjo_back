<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getProfile()
    {
        $user = auth()->user();
        return $this->success([
            'username' => $user->username,
            'phone' => $user->phone,
            'phone_verified_at' => $user->phone_verified_at,
            'created_at' => $user->created_at,
        ]);
    }
}
