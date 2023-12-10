<?php

namespace CodeLink\Booster\Helpers;

use CodeLink\Booster\Services\SentOtp;

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
}
