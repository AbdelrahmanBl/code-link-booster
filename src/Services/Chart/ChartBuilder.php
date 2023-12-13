<?php

namespace CodeLink\Booster\Services\Chart;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ChartBuilder
{
    /**
     * generate monthly report.
     *
     * @param  Builder $builder
     * @param  string $dateField
     * @param  bool $fromNow
     * @return array
     */
    public static function monthly($builder, $dateField = null, $fromNow = false): array
    {
        $endAt      = today()->addMonth();
        $startFrom  = today()->addMonth()->subYear();

        if($fromNow) {
            $startFrom  = today();
            $endAt      = today()->addYear();
        }

        if(! $dateField) {
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

        while($startFrom < $endAt) {

            $month = (int) $startFrom->format('m');

            $item  = $data->where('month', $month)->first();

            $chart->add(trans("booster::message.months.$month"), $item?->count ?? 0);

            $startFrom->addMonth();

        }

        return $chart->data;
    }

    /**
     * generate report with count.
     *
     * @param  Builder $builder
     * @param  string $relationName
     * @param  string $labelKey
     * @param  string $orderBy
     * @return array
     */
    public static function count($builder, $relationName, $labelKey = null, $orderBy = 'desc'): array
    {
        $relationKey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $relationName)) . '_count';

        if(! $labelKey) {
            $labelKey = config('booster.services.chart_service.label_key');
        }

        $data = $builder->select([config('booster.services.chart_service.id_key'), $labelKey])
        ->whereHas("{$relationName}")
        ->withCount("{$relationName}")
        ->orderBy($relationKey, $orderBy)
        ->limit(config('booster.services.chart_service.top_rated_length'))
        ->get();

        $chart = new Chart();

        foreach($data as $item) {
            $chart->add($item->{$labelKey}, $item->{$relationKey});
        }

        return $chart->data;
    }

    /**
     * generate report with sum.
     *
     * @param  Builder $builder
     * @param  string $relationName
     * @param  string $sumKey
     * @param  string $labelKey
     * @param  string $orderBy
     * @return array
     */
    public static function sum($builder, $relationName, $sumKey, $labelKey = null, $orderBy = 'desc'): array
    {
        $relationKey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $relationName)) . '_sum_' . str_replace('.', '', $sumKey);

        if(! $labelKey) {
            $labelKey = config('booster.services.chart_service.label_key');
        }

        $data = $builder->select([config('booster.services.chart_service.id_key'), $labelKey])
        ->whereHas("{$relationName}")
        ->withSum("{$relationName}", $sumKey)
        ->orderBy($relationKey, $orderBy)
        ->limit(config('booster.services.chart_service.top_rated_length'))
        ->get();

        $chart = new Chart();

        foreach($data as $item) {
            $chart->add($item->{$labelKey}, $item->{$relationKey});
        }

        return $chart->data;
    }
}
