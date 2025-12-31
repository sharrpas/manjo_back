<?php

namespace App\Traits;

use Ipe\Sdk\Facades\SmsIr;

trait SmsSender
{
    public function SMS($messageText, $mobile)
    {
        $lineNumber = "90003591";
        $sendDateTime = null;
        $mobiles[0] = $mobile;

        SmsIr::bulkSend($lineNumber, $messageText, $mobiles, $sendDateTime);

    }

    public function sendOtpTemp($otp)
    {
        $text = " کد تایید شما: $otp \n" .
            "مانجو سوخاری\n";

        return $text;
    }

    public function sendWelcome()
    {
        $text = "به سوخاری مانجو خوش امدید";

        return $text;
    }

    public function sendToken($url)
    {
        $text = "به مانجو سوخاری خوش آمدید." . "\n" .
            "بازی کن. سوخاری رایگان ببر!" . "\n" .
            "برای ورود به بازی روی لینک زیر کلیک کنید:" . "\n" .
            $url;

        return $text;
    }
}
