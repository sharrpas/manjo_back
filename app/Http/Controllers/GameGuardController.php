<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Http\Requests\SubmitScoreRequest;
use App\Models\User;
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

        return $this->error(Status::AUTHENTICATION_FAILED, [
            'valid' => false,
        ]);
    }


    public function submitScore(SubmitScoreRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $user->gameRecords()->create([
            'score' => $request->score,
            'data' => json_encode($request->validated()),
        ]);
        return $this->success('saved');
    }
}
