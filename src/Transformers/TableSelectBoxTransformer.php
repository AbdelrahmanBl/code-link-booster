<?php

namespace CodeLink\Booster\Transformers;

use Illuminate\Database\Eloquent\Builder;

class TableSelectBoxTransformer
{
    public static function transform(Builder $queryBuilder, string $labelKey = null, string $valueKey = null, array $extraSelect = []): array
    {
        if(empty($labelKey)) {
            $labelKey = config('booster.transformers.select_box_table.label_key');
        }

        if(empty($valueKey)) {
            $valueKey = config('booster.transformers.select_box_table.value_key');
        }

        $select = empty($extraSelect)
        ? [$labelKey, $valueKey]
        : $extraSelect;

        return $queryBuilder->select($select)
        ->get()
        ->map(fn($item) => [
            config('booster.transformers.select_box.label_key') => $item->{$labelKey},
            config('booster.transformers.select_box.value_key') => $item->{$valueKey},
        ])
        ->toArray();
    }
}
