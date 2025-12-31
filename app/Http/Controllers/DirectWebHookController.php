<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Http\Requests\DirectRequest;
use App\Models\DirectSetting;
use App\Models\User;
use App\Traits\GeneratesUniqueUidTrait;
use App\Traits\SmsSender;
use Illuminate\Support\Facades\Log;

class DirectWebHookController extends Controller
{
    use GeneratesUniqueUidTrait, SmsSender;

    public function store(DirectRequest $request)
    {
        $macValue = DirectSetting::query()->where('name', 'mac')->first();
        if ($request->mac != json_decode($macValue->value)) {
            Log::error('مک ادرس ارسال شده صحیح نمی باشد: ' . $request->mac);
            return $this->error(Status::PERMISSION_DENIED, 'مک ادرس ارسال شده صحیح نمی باشد');
        }

        $user = User::query()->where('phone', $request->phone)->first();

        if (!$user) {
            $username = $this->generateUniqueUid(User::class);
            $user = User::query()->create([
                'username' => $username,
                'phone' => $request->phone,
                'phone_verified_at' => now(),
            ]);
        }

        $token = $user->createToken(
            name: 'token_base_name',
            expiresAt: now()->addMinutes(config('sanctum.expiration')))
            ->plainTextToken;


        $url = env('APP_URL_FRONTEND') . '/direct-login?token=' . $token;
        if (env('SEND_SMS') == 1) {
            $this->SMS($this->sendToken($url), $request->phone);
        }
    }
}
