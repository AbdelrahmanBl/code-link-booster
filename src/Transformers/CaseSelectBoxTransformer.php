<?php

namespace CodeLink\Booster\Transformers;

class CaseSelectBoxTransformer
{
    public static function transform(array $cases, string $locale = NULL): array
    {
        if(empty($cases)) {
            return [];
        }

        if(empty($locale)) {
            $locale = config('booster.transformers.enum_translation_file') . '.' . class_basename($cases[0]);
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
