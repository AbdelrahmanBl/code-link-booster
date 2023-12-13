<?php

namespace CodeLink\Booster\Enums;

enum OtpGateway: string
{
    case SMS = 'sms';
    case EMAIL = 'email';
}
