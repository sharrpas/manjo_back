<?php

namespace App\Http\Controllers\Admin;


use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\PhoneValidator;
use Illuminate\Http\Request;

class AdminAuthenticationController extends Controller
{
    use PhoneValidator;

    public function login(Request $request)
    {
        $validateOTP = $this->validate($request->phone, $request->otp);
        if (!$validateOTP) {
            return $this->error(Status::PERMISSION_DENIED, 'کد تایید اشتباه است');
        }
        $user = User::query()->where('phone', $request->phone)->first();
        if ($user->hasRole('admin')) {
            $token = $$user->createToken(
                name: 'admin_token',
                expiresAt: now()->addMinutes(config('sanctum.expiration')))
                ->plainTextToken;
            return $this->success(['token' => $token]);
        } else {
            return $this->error(Status::PERMISSION_DENIED, 'شما دسترسی ادمین ندارید');
        }


    }
}
