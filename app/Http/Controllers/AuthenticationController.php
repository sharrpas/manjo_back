<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Http\Requests\VerifyPhoneRequest;
use App\Models\User;
use App\Traits\GeneratesUniqueUidTrait;
use App\Traits\PhoneValidator;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    use GeneratesUniqueUidTrait, PhoneValidator;

    public function login()
    {
        $username = $this->generateUniqueUid(User::class);
        $user = User::query()->create([
            'username' => $username,
        ]);

        return $this->success([
            'username' => $user->username,
            'token' => $user->createToken(
                name: 'token_base_name',
                expiresAt: now()->addMinutes(config('sanctum.expiration')))
                ->plainTextToken,
            'expiration' => (config('sanctum.expiration')/24/60) . ' days',
        ]);
    }

    public function verifyPhone(VerifyPhoneRequest $request)
    {
        $validateOTP = $this->validate($request->phone,$request->otp);
        if (!$validateOTP){
            return $this->error(Status::PERMISSION_DENIED,'کد تایید اشتباه است');
        }

        /** @var User $cacheUser */
        $cacheUser = auth()->user();
        $user = User::query()->where('phone', $request->phone)->first();

        if (!$user){
            $cacheUser->update([
                'phone' => $request->phone,
                'phone_verified_at' => now(),
            ]);
            $user = $cacheUser;
        }else{
            $user->gameRecords()->update(['user_id' => $cacheUser->id]);
            $cacheUser->delete();
        }

        return $this->success([
            'username' => $user->username,
            'token' => $user->createToken(
                name: 'token_base_name',
                expiresAt: now()->addMinutes(config('sanctum.expiration')))
                ->plainTextToken,
            'expiration' => (config('sanctum.expiration')/24/60) . ' days',
        ]);
    }
}
