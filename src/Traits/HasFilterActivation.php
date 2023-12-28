<?php

namespace CodeLink\Booster\Traits;

trait HasFilterActivation
{
    public function filterActivation()
    {
        return $this->when(in_array(request('is_active'), ['1', '0']), function($query) {
            $query->where('is_active', (bool) request('is_active'));
        });
    }
}
