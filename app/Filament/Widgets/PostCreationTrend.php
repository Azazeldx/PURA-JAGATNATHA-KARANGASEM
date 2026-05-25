<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;

class PostCreationTrend extends ChartWidget
{
    use HasWidgetShield;

    protected ?string $heading = 'Post Creation Trend';

    protected function getData(): array
    {
        $data = cache()->remember('dashboard.post_creation_trend', 300, function () {

            $months = collect(range(11, 0))->map(function ($i) {
                $date = now()->subMonths($i);

                return [
                    'label' => $date->format('M Y'),
                    'count' => Post::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->count(),
                ];
            });

            return [
                'labels' => $months->pluck('label')->toArray(),
                'data' => $months->pluck('count')->toArray(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Posts',
                    'data' => $data['data'],
                    'fill' => true,
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
