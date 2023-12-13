<?php

namespace CodeLink\Booster\Services\Chart;

class ChartGenerator
{
    public array $statistics = [];

    public array $pieCharts = [];

    public array $barCharts = [];

    public array $lineCharts = [];

    public function addStatistic(string $title, $value,?string $route= null): self
    {
        $this->statistics[] = [
            'label' => $title,
            'value' => $value,
            'route' => $route
        ];

        return $this;
    }

    public function addPieChart(Chart $chart): self
    {
        $this->pieCharts[] = $this->getChartBody($chart);

        return $this;
    }

    public function addBarChart(Chart $chart): self
    {
        $this->barCharts[] = $this->getChartBody($chart);

        return $this;
    }

    public function addLineChart(Chart $chart): self
    {
        $this->lineCharts[] = $this->getChartBody($chart);

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
        ];
    }
}
