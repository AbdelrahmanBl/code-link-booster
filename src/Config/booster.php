<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Develop Server Url
    |--------------------------------------------------------------------------
    |
    | The development server url to be used in:
    | - check devlopment mode in otp service for generate static code `1234` when not in proudction.
    |
    */
    'develop_server_url' => env('BOOSTER_DEVELOP_SERVER_URL', 'dev.test.com'),

    'services' => [

        /*
        |--------------------------------------------------------------------------
        | Otp Service
        |--------------------------------------------------------------------------
        |
        | Allow/Disallow the otp service in the booster.
        | Sms service to be used when sending sms by a gateway.
        | The otp timeout for otp code expiry.
        |
        */
        'otp_service' => [
            'allow' => env('BOOSTER_ALLOW_OTP_SERVICE', true),
            'mailable_subject' => env('BOOSTER_MAILABLE_SUBJECT', 'Otp'),
            'mailable_markdown' => env('BOOSTER_MAILABLE_MARKDOWN', 'booster::otp'),
            'mailable' => env('BOOSTER_MAILABLE', \CodeLink\Booster\Mails\OtpMail::class),
            'sms_service' => env('BOOSTER_SMS_SERVICE', \CodeLink\Booster\Services\SmsService::class),
            'otp_timeout' => env('BOOSTER_OTP_TIMEOUT', 10),
        ]
    ]
];
