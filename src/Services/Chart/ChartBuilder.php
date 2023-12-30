<?php

namespace CodeLink\Booster\Services\Chart;

use CodeLink\Booster\Arrays\DummyColors;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ChartBuilder
{
    /**
     * generate monthly report.
     *
     * @param  Builder $builder
     * @param  string|null $dateField
     * @param  bool $fromNow
     * @return array
     */
    public static function monthly($builder, $dateField = null, $fromNow = false): array
    {
        $endAt      = today();
        $startFrom  = today()->addMonth()->subYear();

        if($fromNow) {
            $startFrom  = today();
            $endAt      = today()->subMonth()->addYear();
        }

        $startFrom = $startFrom->firstOfMonth();
        $endAt = $endAt->endOfMonth();

        if(empty($dateField)) {
            $dateField = config('booster.services.chart_service.monthly_date_field');
        }

        $data = $builder->whereBetween($dateField, [$startFrom, $endAt])
        ->select([
            DB::raw("MONTH({$dateField}) as month"),
            DB::raw("YEAR({$dateField}) as year"),
            DB::raw('COUNT(*) as count'),
        ])
        ->groupBy('month')
        ->groupBy('year')
        ->get();

        $chart = new Chart();
        $colors = DummyColors::toArray();
        $index = 0;

        while($startFrom < $endAt) {

            $month = (int) $startFrom->format('m');

            $item  = $data->where('month', $month)->first();

            $chart->add(trans("booster::message.months.$month"), $item?->count ?? 0, $colors[$index++]);

            $startFrom->addMonth();

        }

        return $chart->data;
    }

    /**
     * generate report with count.
     *
     * @param  Builder $builder
     * @param  string|array $relation
     * @param  callable|string|null $label
     * @param  string $orderBy
     * @param  array $extraSelect
     * @return array
     */
    public static function count(Builder $builder, $relation, $label = null, $orderBy = 'desc', array $extraSelect = []): array
    {
        if(is_string($relation)) {
            $relation = [$relation, null];
        }
        else if(is_array($relation)) {
            $relation = [array_key_first($relation), array_values($relation)[0]];
        }

        list($relationName, $relationCallback) = $relation;

        $relationKey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $relationName)) . '_count';

        if(empty($label)) {
            $label = config('booster.services.chart_service.label_key');
        }

        $select = empty($extraSelect)
        ? [config('booster.services.chart_service.id_key'), $label]
        : $extraSelect;

        $data = $builder->select($select)
        ->when($relationCallback, function($query, $relationCallback) use ($relationName) {
            $query->whereHas("{$relationName}", $relationCallback, '>=', 0);
        })
        ->withCount("{$relationName}")
        ->orderBy($relationKey, $orderBy)
        ->limit(config('booster.services.chart_service.top_rated_length'))
        ->get();

        $chart = new Chart();
        $colors = DummyColors::toArray();

        foreach($data as $index => $item) {
            $chart->add(
                is_callable($label) ? $label($item) : $item->{$label},
                $item->{$relationKey},
                $colors[$index]
            );
        }

        return $chart->data;
    }

    /**
     * generate report with sum.
     *
     * @param  Builder $builder
     * @param  string|array $relation
     * @param  string $sumKey
     * @param  callable|string|null $label
     * @param  string $orderBy
     * @param  array $extraSelect
     * @return array
     */
    public static function sum($builder, $relation, $sumKey, $label = null, $orderBy = 'desc', array $extraSelect = []): array
    {
        if(is_string($relation)) {
            $relation = [$relation, null];
        }
        else if(is_array($relation)) {
            $relation = [array_key_first($relation), array_values($relation)[0]];
        }

        list($relationName, $relationCallback) = $relation;

        $relationKey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $relationName)) . '_sum_' . str_replace('.', '', $sumKey);

        if(empty($label)) {
            $label = config('booster.services.chart_service.label_key');
        }

        $select = empty($extraSelect)
        ? [config('booster.services.chart_service.id_key'), $label]
        : $extraSelect;

        $data = $builder->select($select)
        ->when($relationCallback, function($query, $relationCallback) use ($relationName) {
            $query->whereHas("{$relationName}", $relationCallback, '>=', 0);
        })
        ->withSum("{$relationName}", $sumKey)
        ->orderBy($relationKey, $orderBy)
        ->limit(config('booster.services.chart_service.top_rated_length'))
        ->get();

        $chart = new Chart();
        $colors = DummyColors::toArray();

        foreach($data as $index => $item) {
            $chart->add(
                is_callable($label) ? $label($item) : $item->{$label},
                $item->{$relationKey},
                $colors[$index]
            );
        }

        return $chart->data;
    }

    /**
     * generate report with average.
     *
     * @param  Builder $builder
     * @param  string|array $relation
     * @param  string $avgKey
     * @param  callable|string|null $label
     * @param  string $orderBy
     * @param  array $extraSelect
     * @return array
     */
    public static function avg($builder, $relation, $avgKey, $label = null, $orderBy = 'desc', array $extraSelect = []): array
    {
        if(is_string($relation)) {
            $relation = [$relation, null];
        }
        else if(is_array($relation)) {
            $relation = [array_key_first($relation), array_values($relation)[0]];
        }

        list($relationName, $relationCallback) = $relation;

        $relationKey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $relationName)) . '_avg_' . str_replace('.', '', $avgKey);

        if(empty($label)) {
            $label = config('booster.services.chart_service.label_key');
        }

        $select = empty($extraSelect)
        ? [config('booster.services.chart_service.id_key'), $label]
        : $extraSelect;

        $data = $builder->select($select)
        ->when($relationCallback, function($query, $relationCallback) use ($relationName) {
            $query->whereHas("{$relationName}", $relationCallback, '>=', 0);
        })
        ->withAvg("{$relationName}", $avgKey)
        ->orderBy($relationKey, $orderBy)
        ->limit(config('booster.services.chart_service.top_rated_length'))
        ->get();

        $chart = new Chart();
        $colors = DummyColors::toArray();

        foreach($data as $index => $item) {
            $chart->add(
                is_callable($label) ? $label($item) : $item->{$label},
                round($item->{$relationKey}, 1),
                $colors[$index]
            );
        }

        return $chart->data;
    }

    /**
     * generate report with enum.
     *
     * @param  Builder $builder
     * @param  array $cases
     * @param  string|null $labelKey
     * @param  string $orderBy
     * @param  string|null $locale
     * @return array
     */
    public static function enum($builder, $cases, $labelKey = null, $orderBy = 'desc', string $locale = null): array
    {
        if(empty($labelKey)) {
            $labelKey = config('booster.services.chart_service.label_key');
        }

        if(empty($locale)) {
            $locale = config('booster.transformers.enum_translation_file') . '.' . class_basename($cases[0]);
        }

        $data = $builder->select($labelKey, DB::raw("COUNT($labelKey) as count"))
        ->groupBy($labelKey)
        ->get();

        $chart = new Chart();
        $colors = DummyColors::toArray();

        foreach($cases as $index => $case) {
            $chart->add(
                __("$locale.{$case->value}"),
                $data->where($labelKey, $case)->first()?->count ?? 0,
                $colors[$index]
            );
        }

        $chartCollection = match($orderBy) {
            'desc' => collect($chart->data)->sortByDesc(fn($i) => $i['value']),
            'asc' => collect($chart->data)->sortBy(fn($i) => $i['value']),
        };

        return $chartCollection->values()->toArray();
    }
}
