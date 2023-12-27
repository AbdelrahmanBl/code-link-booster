<?php

namespace CodeLink\Booster\Enums;

use CodeLink\Booster\Traits\EnumHandler;

enum NotifyBy: string
{
    use EnumHandler;

    case DATABASE = 'database';
    case MAIL = 'mail';
    case FCM = 'fcm';
}
