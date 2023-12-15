<?php

namespace CodeLink\Booster\Mixins;

class ArrayMixin
{
    /**
     * depending on spatie translatable package...
     *
     * @return array
     */
    public function translateValues()
    {
        return fn($array) => array_map(function($item) {
            return is_array($item)
            ? $item[app()->getLocale()]
            : $item;
        }, $array);
    }
}
