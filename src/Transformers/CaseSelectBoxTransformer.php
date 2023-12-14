<?php

namespace CodeLink\Booster\Transformers;

class CaseSelectBoxTransformer
{
    public static function make(): self
    {
        return new self;
    }

    public function transform(array $cases, string $locale = NULL)
    {
        if(empty($cases)) {
            return [];
        }

        if(empty($locale)) {
            $locale = 'enums.' . class_basename($cases[0]);
        }

        return array_map(
            fn($case) => [
                config('booster.transformers.select_box.label_key') => __("$locale.{$case->value}"),
                config('booster.transformers.select_box.value_key') => $case->value,
            ],
            $cases
        );
    }
}
