<?php

namespace CodeLink\Booster\Services\Chart;

class Chart
{
    public string $title;

    public array $data;

    public bool $fullWidth;

    public function __construct(string $title = '', $data = [], bool $fullWidth = false)
    {
        $this->title = $title;
        $this->data = $data;
        $this->fullWidth = $fullWidth;
    }

    public function add(string $label, $value, $color = null): self
    {
        $this->data[] = compact('label', 'value', 'color');

        return $this;
    }
}
