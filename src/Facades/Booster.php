<?php

namespace CodeLink\Booster\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool sentOtpByEmail(string $email)
 * @method static bool sentOtpBySms(string $mobile)
 * @method static bool verifyOtp(string $target, string $otp)
 */
class Booster extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'booster';
    }
}
