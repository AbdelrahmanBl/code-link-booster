<?php

namespace CodeLink\Booster\Helpers;

use CodeLink\Booster\Services\SentOtp;
use CodeLink\Booster\Services\VerifyOtp;

class BoosterHelper
{
    public function sentOtpByEmail(string $email): bool
    {
        return SentOtp::create()->toEmail($email);
    }

    public function sentOtpBySms(string $mobile): bool
    {
        return SentOtp::create()->toMobile($mobile);
    }

    public function verifyOtp(string $target, string $otp): bool
    {
        return VerifyOtp::create()->verify($target, $otp);
    }
}
