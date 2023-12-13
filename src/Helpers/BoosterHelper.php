<?php

namespace CodeLink\Booster\Helpers;

use CodeLink\Booster\Services\SentOtp;
use CodeLink\Booster\Services\VerifyOtp;

class BoosterHelper
{
    public function sentOtpByEmail(string $email, int $otpLength = null): bool
    {
        return SentOtp::create()->setOtpLength($otpLength)->toEmail($email);
    }

    public function sentOtpBySms(string $mobile, int $otpLength = null): bool
    {
        return SentOtp::create()->setOtpLength($otpLength)->toMobile($mobile);
    }

    public function verifyOtp(string $target, string $otp): bool
    {
        return VerifyOtp::create()->verify($target, $otp);
    }
}
