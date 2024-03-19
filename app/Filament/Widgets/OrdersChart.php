<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource\Pages\ListOrders;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrdersChart extends ChartWidget
{
    use InteractsWithPageTable;

    protected static ?string $heading = 'Pedidos realizados por período';

    protected static ?string $pollingInterval = '60s';

    protected int|string|array $columnSpan = 'full';

    protected static ?string $maxHeight = '200px';

    public ?string $filter = '3months';

    protected static ?int $sort = 1;

    protected static string $color = 'info';

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false,
            ],
        ],
    ];

    protected function getFilters(): ?array
    {
        return [
            'week' => 'Ultima Semana',
            'month' => 'Ultimo Mês',
            '3months' => 'Ultimos 3 Meses',
        ];
    }

    protected function getTablePage(): string
    {
        return ListOrders::class;
    }

    protected function getData(): array
    {
        $filter = $this->filter;

        $query = $this->getPageTableQuery();
        $query->getQuery()->orders = [];

        match ($filter) {
            'week' => $data = Trend::query($query)
                ->between(
                    start: now()->subWeek(),
                    end: now(),
                )
                ->perDay()
                ->count(),
            'month' => $data = Trend::query($query)
                ->between(
                    start: now()->subMonth(),
                    end: now(),
                )
                ->perDay()
                ->count(),
            '3months' => $data = Trend::query($query)
                ->between(
                    start: now()->subMonths(3),
                    end: now(),
                )
                ->perMonth()
                ->count(),
        };

        return [
            'datasets' => [
                [
                    'label' => 'Pedidos',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('d-m')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
