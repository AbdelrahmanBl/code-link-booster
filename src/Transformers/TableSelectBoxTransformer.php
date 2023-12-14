<?php

namespace CodeLink\Booster\Transformers;

use Illuminate\Database\Eloquent\Builder;

class TableSelectBoxTransformer
{
    public static function make(): self
    {
        return new self;
    }

    public function transform(Builder $queryBuilder, string $labelKey = null, string $valueKey = null)
    {
        if(empty($labelKey)) {
            $labelKey = config('booster.transformers.select_box_table.label_key');
        }

        if(empty($valueKey)) {
            $valueKey = config('booster.transformers.select_box_table.value_key');
        }

        return $queryBuilder->select($valueKey, $labelKey)
        ->get()
        ->map(fn($item) => [
            config('booster.transformers.select_box.label_key') => $item->{$labelKey},
            config('booster.transformers.select_box.value_key') => $item->{$valueKey},
        ])
        ->toArray();
    }
}
