<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use Illuminate\Http\Request;

class GameGuardController extends Controller
{
    public function verifyToken()
    {
        $user = auth()->user();
        if ($user) {
            return $this->success([
                'valid' => true,
                'username' => $user->username,
            ]);
        }

        return $this->error(Status::AUTHENTICATION_FAILED,[
            'valid' => false,
        ]);
    }
}
