<?php

namespace CodeLink\Booster\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasGlobalScopeSortable
{
    public static function bootHasGlobalScopeSortable()
    {
        static::addGlobalScope('sortableScope', function(Builder $builder) {
            $builder->ordered();
        });
    }
}
