<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AllPostOverview extends StatsOverviewWidget
{
    use HasWidgetShield;

    protected function getStats(): array
    {
        // ===== CACHE LAYER =====
        $data = cache()->remember('dashboard.stats_overview', 60, function () {

            // ===== BASIC COUNTS =====
            $totalPosts = Post::count();
            $publishedPosts = Post::whereNotNull('published_at')->count();
            $draftPosts = Post::whereNull('published_at')->count();

            $publishRate = $totalPosts > 0
                ? round(($publishedPosts / $totalPosts) * 100, 1)
                : 0;

            // ===== TREND (7 DAYS) =====
            $trend = collect(range(6, 0))->map(function ($day) {
                return [
                    'date' => Carbon::now()->subDays($day),
                    'total' => Post::whereDate('created_at', Carbon::now()->subDays($day))->count(),
                    'published' => Post::whereDate('published_at', Carbon::now()->subDays($day))->count(),
                ];
            });

            // ===== PREVIOUS PERIOD (FOR DELTA) =====
            $prevTotal = Post::whereBetween('created_at', [
                now()->subDays(14),
                now()->subDays(7)
            ])->count();

            $currentTotal = Post::whereBetween('created_at', [
                now()->subDays(7),
                now()
            ])->count();

            $delta = $prevTotal > 0
                ? round((($currentTotal - $prevTotal) / $prevTotal) * 100, 1)
                : 0;

            return [
                'totalPosts' => $totalPosts,
                'publishedPosts' => $publishedPosts,
                'draftPosts' => $draftPosts,
                'publishRate' => $publishRate,
                'trend' => $trend,
                'delta' => $delta,
            ];
        });

        return [

            // ===== TOTAL POSTS =====
            Stat::make('Total Posts', $data['totalPosts'])
                ->description($data['delta'] . '% vs last week')
                ->descriptionIcon(
                    $data['delta'] >= 0
                        ? 'heroicon-m-arrow-trending-up'
                        : 'heroicon-m-arrow-trending-down'
                )
                ->chart($data['trend']->pluck('total')->toArray())
                ->color($data['delta'] >= 0 ? 'success' : 'danger'),

            // ===== DRAFT POSTS =====
            Stat::make('Drafts', $data['draftPosts'])
                ->description('Pending publish')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->chart(
                    $data['trend']->map(fn ($d) => $d['total'] - $d['published'])->toArray()
                )
                ->color('warning'),

            // ===== PUBLISHED POSTS =====
            Stat::make('Published', $data['publishedPosts'])
                ->description('Content live')
                ->descriptionIcon('heroicon-m-check-circle')
                ->chart($data['trend']->pluck('published')->toArray())
                ->color('success'),

            // ===== PUBLISH RATE =====
            Stat::make('Publish Rate', $data['publishRate'] . '%')
                ->description('Published / total posts')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->chart(
                    $data['trend']->map(function ($d) {
                        return $d['total'] > 0
                            ? round(($d['published'] / $d['total']) * 100, 1)
                            : 0;
                    })->toArray()
                )
                ->color('info'),
        ];
    }
}
