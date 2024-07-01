<?php

namespace CodeLink\Booster\Traits;

trait HasFilterSoftDeletes
{
    public function filterSoftDeletes()
    {
        return $this->when(in_array(request('is_deleted'), ['1', '0']), function($query) {
            (bool) request('is_deleted')
            ? $query->whereNotNull('deleted_at')
            : $query->whereNull('deleted_at');
        });
    }
}
