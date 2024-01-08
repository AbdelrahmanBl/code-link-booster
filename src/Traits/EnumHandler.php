<?php

namespace CodeLink\Booster\Traits;

use CodeLink\Booster\Facades\Booster;
use Illuminate\Support\Collection;

trait EnumHandler
{
    public static function names(): Collection
    {
        return collect(array_column(static::cases(), 'name'));
    }

    public static function values(): Collection
    {
        return collect(array_column(static::cases(), 'value'));
    }

    public static function options($locale = null): array
    {
        return Booster::getSelectBoxEnumOptions(static::cases(), $locale);
    }
}
