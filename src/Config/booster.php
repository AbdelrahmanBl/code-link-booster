<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Develop Server Url
    |--------------------------------------------------------------------------
    |
    | The development server url to be used in:
    | - check devlopment mode in otp service for generate static code `0000` (depending on the otp length) when not in proudction.
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
            'allow' => env('BOOSTER_OTP_ALLOW', false),

            # Otp model for storing the verification code.
            'model' => CodeLink\Booster\Models\Otp::class,

            # Mailable for otp mail class.
            'mailable' => CodeLink\Booster\Mails\OtpMail::class,

            # Sms service to be used when sending sms by a gateway.
            'sms_service' => CodeLink\Booster\Services\Otp\SmsService::class,

            # Mailable markdown for email html template.
            'mailable_markdown' => 'booster::otp',

            # Mailable subject for email title.
            'mailable_subject' => env('BOOSTER_OTP_MAILABLE_SUBJECT', 'Otp'),

            # The otp timeout for otp code expiry.
            'otp_timeout' => env('BOOSTER_OTP_TIMEOUT', 10), # in mintues

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
            'monthly_date_field' => 'created_at',

            # The default label key field for chart builder [count - sum] methods.
            'label_key' => 'name',

            # The default id key field for chart builder [count - sum] methods.
            'id_key' => 'id',

            # The default dummy colors class.
            'dummy_colors' => CodeLink\Booster\Arrays\DummyColors::class,
        ],
    ],

    'transformers' => [

        'enum_translation_file' => 'enums',

        /*
        |--------------------------------------------------------------------------
        | Select Box
        |--------------------------------------------------------------------------
        |
        */
        'select_box' => [
            'label_key' => 'label',
            'value_key' => 'value',
        ],

        /*
        |--------------------------------------------------------------------------
        | Select Box Table
        |--------------------------------------------------------------------------
        |
        */
        'select_box_table' => [

            # The default name key field for select box label.
            'label_key' => 'name',

            # The default value key field for select box value.
            'value_key' => 'id',
        ]
    ],

    'notifications' => [

        'via' => [
            CodeLink\Booster\Enums\NotifyBy::DATABASE,
            CodeLink\Booster\Enums\NotifyBy::MAIL,
            CodeLink\Booster\Enums\NotifyBy::FCM,
        ],

        'fcm_channel' => NULL, // \NotificationChannels\Fcm\FcmChannel::class,

        'fcm_service' => CodeLink\Booster\Services\FcmService::class,

    ],

    'requests' => [
        'export_excel_key' => 'export_excel',

        'show_report_key' => 'show_report',

        'download_draft_key' => 'download_draft',
    ],
];
