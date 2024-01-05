<?php

namespace CodeLink\Booster\Services\Chart;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ChartGenerator
{
    public array $statistics = [];

    public array $pieCharts = [];

    public array $barCharts = [];

    public array $lineCharts = [];

    public function addStatistic(string $title, $value,?string $route= null, ?string $icon = null): self
    {
        if($route) {
            // get all query parameters without show report key...
            $queryParams = collect(request()->query())
            ->filter(fn($i, $key) => $key !== config('booster.requests.show_report_key'))
            ->toArray();

            // overwrite origin query parameters with the route params...
            $queryParams = array_merge(Str::urlParser($route), Arr::withoutNullable($queryParams));

            // remove query parameters from the route...
            $route = strtok($route, '?');

            $route = $route . '?' . http_build_query($queryParams);
        }


        $this->statistics[] = [
            'label' => $title,
            'value' => $value,
            'route' => $route,
            'icon' => $icon,
        ];

        return $this;
    }

    public function addStatisticWhen(mixed $condition, string $title, $value,?string $route= null, ?string $icon = null): self
    {
        if($condition) {
            $this->addStatistic($title, $value, $route, $icon);
        }

        return $this;
    }

    public function addPieChart(Chart $chart): self
    {
        $this->pieCharts[] = $this->getChartBody($chart);

        return $this;
    }

    public function addPieChartWhen(mixed $condition, Chart $chart): self
    {
        if($condition) {
            $this->addPieChart($chart);
        }

        return $this;
    }

    public function addBarChart(Chart $chart): self
    {
        $this->barCharts[] = $this->getChartBody($chart);

        return $this;
    }

    public function addBarChartWhen(mixed $condition, Chart $chart): self
    {
        if($condition) {
            $this->addBarChart($chart);
        }

        return $this;
    }

    public function addLineChart(Chart $chart): self
    {
        $this->lineCharts[] = $this->getChartBody($chart);

        return $this;
    }

    public function addLineChartWhen(mixed $condition, Chart $chart): self
    {
        if($condition) {
            $this->addLineChart($chart);
        }

        return $this;
    }

    public function generate(): array
    {
        return [
            'statistics'    => $this->statistics,
            'pieCharts'     => $this->pieCharts,
            'barCharts'     => $this->barCharts,
            'lineCharts'    => $this->lineCharts,
        ];
    }

    private function getChartBody(Chart $chart): array
    {
        return [
            'title' => $chart->title,
            'chartData' => $chart->data,
            'fullWidth' => $chart->fullWidth,
        ];
    }
}
