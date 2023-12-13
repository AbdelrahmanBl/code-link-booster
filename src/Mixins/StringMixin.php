<?php

namespace CodeLink\Booster\Mixins;

class StringMixin
{
    public function otp()
    {
        return function($length = 4) {

            $isDev = app()->isDev();

            $otp = '';
            for($i = 0; $i < $length; $i++) {
                $otp .= $isDev
                ? 0
                : rand(0, 9);
            }

            return $otp;
        };
    }
}
