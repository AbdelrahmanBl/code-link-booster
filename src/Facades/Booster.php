<?php

namespace CodeLink\Booster\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \CodeLink\Booster\Helpers\BoosterHelper sentOtpByEmail(string $email): bool
 * @method static \CodeLink\Booster\Helpers\BoosterHelper sentOtpBySms(string $mobile): bool
 */
class Booster extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'booster';
    }
}
