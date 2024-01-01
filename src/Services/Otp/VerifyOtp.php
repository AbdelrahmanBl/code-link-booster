<?php

namespace CodeLink\Booster\Services\Otp;

use CodeLink\Booster\Models\Otp;
use CodeLink\Booster\Exceptions\InvalidOtpException;

class VerifyOtp
{
    public static function verify(string $target, string $otp): bool
    {
        $model = Otp::query()->find($target);

        if(! $model) {
            throw new InvalidOtpException(trans('booster::message.code_missing'));
        }

        if($model->is_expired) {
            throw new InvalidOtpException(trans('booster::message.code_expired'));
        }

        if(! $model->verify($otp)) {
            throw new InvalidOtpException(trans('booster::message.code_wrong'));
        }

        return true;
    }
}
