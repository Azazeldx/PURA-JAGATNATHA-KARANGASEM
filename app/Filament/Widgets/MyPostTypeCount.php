<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;

class MyPostTypeCount extends ChartWidget
{
    use HasWidgetShield;

    protected ?string $heading = 'My Posts by Type';

    protected function getData(): array
    {
        $userId = auth()->id();
        $cacheKey = "dashboard.posts_by_type_user_{$userId}";

        $data = cache()->remember($cacheKey, 300, function () use ($userId) {

            $result = Post::query()
                ->where('author_id', $userId)
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
