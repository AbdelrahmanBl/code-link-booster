<?php

namespace CodeLink\Booster\Services\Chart;

class FullWidthChart extends Chart
{
    public function __construct(string $title = '', $data = [])
    {
        parent::__construct($title, $data);

        $this->fullWidth = true;
    }
}
