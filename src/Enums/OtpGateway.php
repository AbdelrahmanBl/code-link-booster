<?php

namespace CodeLink\Booster\Enums;

use CodeLink\Booster\Traits\EnumHandler;

enum OtpGateway: string
{
    use EnumHandler;

    case SMS = 'sms';
    case EMAIL = 'email';
}
