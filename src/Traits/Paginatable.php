<?php

namespace CodeLink\Booster\Traits;

trait Paginatable
{
    public function getPerPage()
    {
        return request('per_page') ?? config('booster.paginatable.per_page');
    }
}
