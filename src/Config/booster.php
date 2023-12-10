<?php

return [
    'services' => [
        'otp_service' => [
            'allow' => env('BOOSTER_ALLOW_OTP_SERVICE', true),
            'sms_service' => env('BOOSTER_SMS_SERVICE', \CodeLink\Booster\Services\SmsService::class),
        ]
    ]
];
