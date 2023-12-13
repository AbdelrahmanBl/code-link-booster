<?php

namespace CodeLink\Booster\Services;

use CodeLink\Booster\Models\Otp;
use Illuminate\Validation\ValidationException;

class VerifyOtp
{
    public static function create(): self
    {
        return new self;
    }

    public function verify(string $target, string $otp): bool
    {
        $model = Otp::query()->find($target);

        if(! $model) {
            throw ValidationException::withMessages(['message' => trans('booster::message.code_missing')]);
        }

        if($model->is_expired) {
            throw ValidationException::withMessages(['message' => trans('booster::message.code_expired')]);
        }

        if(! $model->verify($otp)) {
            throw ValidationException::withMessages(['message' => trans('booster::message.code_wrong')]);
        }

        return true;
    }
}
