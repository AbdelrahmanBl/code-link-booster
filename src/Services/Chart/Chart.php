<?php

namespace CodeLink\Booster\Services\Chart;

class Chart
{
    public string $title;

    public array $data;

    public function __construct(string $title = '', $data = [])
    {
        $this->title = $title;
        $this->data = $data;
    }

    public function add(string $label, $value, $color = null): self
    {
        $this->data[] = compact('label', 'value', 'color');

        return $this;
    }
}
