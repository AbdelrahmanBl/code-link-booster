<?php

namespace CodeLink\Booster\Traits;

use Carbon\Carbon;

trait TimestampsTrait
{
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }
}
