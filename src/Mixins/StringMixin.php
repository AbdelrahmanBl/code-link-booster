<?php

namespace CodeLink\Booster\Mixins;

class StringMixin
{
    public function otp()
    {
        return function($otpLength = 4) {
            return app()->isLocal()  || str_contains(url(''), config('booster.develop_server_url'))
            ? match($otpLength) {
                5 => '12345',
                6 => '123456',
                default => '1234',
            }
            : (string) match($otpLength) {
                5 => rand(11111, 99999),
                6 => rand(111111, 999999),
                default => rand(1111, 9999),
            };
        };
    }
}
