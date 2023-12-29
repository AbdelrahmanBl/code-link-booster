<?php

namespace CodeLink\Booster\Arrays;

use CodeLink\Booster\Contracts\StaticArrayable;

class DummyColors implements StaticArrayable
{
    public static function toArray(): array
    {
        return [
            '#41B883',
            '#E46651',
            '#751999',
            '#a19fcf',
            '#9cde0b',
            '#3fabf1',
            '#6a06c9',
            '#9a003d',
            '#777348',
            '#1bef99',
            '#ab7390',
            '#f89153',
            '#185cd4',
            '#dddddd',
            '#e5e509',
            '#000000',
        ];
    }
}
