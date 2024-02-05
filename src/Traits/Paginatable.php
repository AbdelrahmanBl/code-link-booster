<?php

namespace CodeLink\Booster\Traits;

trait Paginatable
{
    public function getPerPage()
    {
        return request(config('booster.paginatable.per_page_key')) ?? config('booster.paginatable.per_page');
    }
}
