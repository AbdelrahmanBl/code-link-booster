<?php

namespace CodeLink\Booster\Services\Otp;

use CodeLink\Booster\Contracts\SmsContract;

class SmsService implements SmsContract
{
    public function send($mobile, $message)
    {
        // ...
    }
}
