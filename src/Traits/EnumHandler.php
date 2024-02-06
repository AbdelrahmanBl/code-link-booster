<?php

namespace CodeLink\Booster\Traits;

use CodeLink\Booster\Facades\Booster;
use Illuminate\Support\Collection;

trait EnumHandler
{
    public static function names(string $static = 'cases'): Collection
    {
        return collect(array_column(static::$static(), 'name'));
    }

    public static function values(string $static = 'cases'): Collection
    {
        return collect(array_column(static::$static(), 'value'));
    }

    public static function options(string $static = 'cases', $locale = null): array
    {
        return Booster::getSelectBoxEnumOptions(static::$static(), $locale);
    }
}
