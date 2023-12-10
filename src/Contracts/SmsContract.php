<?php

namespace CodeLink\Booster\Contracts;

interface SmsContract
{
    public function send($mobile, $message);
}
