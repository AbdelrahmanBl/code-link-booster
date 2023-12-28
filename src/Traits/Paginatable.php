<?php

namespace CodeLink\Booster\Traits;

trait Paginatable
{
    public function getPerPage()
    {
        // TODO defaults to config
        return request('per_page') ?? 10;
    }
}
