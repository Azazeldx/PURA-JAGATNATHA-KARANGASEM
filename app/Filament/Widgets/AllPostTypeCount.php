<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;

class AllPostTypeCount extends ChartWidget
{
    use HasWidgetShield;

    protected ?string $heading = 'Posts by Type';

    protected function getData(): array
    {
        $data = cache()->remember('dashboard.posts_by_type', 300, function () {

            $result = Post::query()
                ->selectRaw('post_type_id, COUNT(*) as total')
                ->groupBy('post_type_id')
                ->with('type')
                ->get()
                ->map(function ($item) {
                    return [
                        'type' => $item->type?->title ?? 'Unknown',
                        'total' => $item->total,
                    ];
                });

            return [
                'labels' => $result->pluck('type')->toArray(),
                'data' => $result->pluck('total')->toArray(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Posts',
                    'data' => $data['data'],
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
