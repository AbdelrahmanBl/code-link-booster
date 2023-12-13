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
        | Otp service is generate an otp of N-numbers and store it in the database,
        | then you can send it by gateways like [email - mobile] gateway.
        | You can verify the otp and send by using booster facade.
        */
        'otp_service' => [
            # Allow/Disallow the otp service in the booster.
            'allow' => env('BOOSTER_OTP_ALLOW', true),

            # Mailable subject for email title.
            'mailable_subject' => env('BOOSTER_OTP_MAILABLE_SUBJECT', 'Otp'),

            # Mailable markdown for email html template.
            'mailable_markdown' => env('BOOSTER_OTP_MAILABLE_MARKDOWN', 'booster::otp'),

            # Mailable for otp mail class.
            'mailable' => env('BOOSTER_OTP_MAILABLE', \CodeLink\Booster\Mails\OtpMail::class),

            # Sms service to be used when sending sms by a gateway.
            'sms_service' => env('BOOSTER_OTP_SMS_SERVICE', \CodeLink\Booster\Services\Otp\SmsService::class),

            # The otp timeout for otp code expiry.
            'otp_timeout' => env('BOOSTER_OTP_TIMEOUT', 10),

            # The default otp length.
            'otp_length' => env('BOOSTER_OTP_LENGTH', 4),
        ],

        /*
        |--------------------------------------------------------------------------
        | Chart Service
        |--------------------------------------------------------------------------
        |
        */
        'chart_service' => [
            # The default top rated length.
            'top_rated_length' => env('BOOSTER_CHART_SERVICE_TOP_RATED_LENGTH', 10),

            # The default date field key name for chart builder monthly method.
            'monthly_date_field' => env('BOOSTER_CHART_SERVICE_MONTHLY_DATE_FIELD', 'created_at'),

            # The default label key field for chart builder [count - sum] methods.
            'label_key' => env('BOOSTER_CHART_SERVICE_LABEL_KEY', 'name'),

            # The default id key field for chart builder [count - sum] methods.
            'id_key' => env('BOOSTER_CHART_SERVICE_ID_KEY', 'id'),
        ],
    ]
];
