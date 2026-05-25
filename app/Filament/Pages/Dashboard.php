<?php

namespace App\Filament\Pages;

use App\Filament\Actions\OptimizeAction;
use App\Filament\Resources\Posts\PostResource;
use App\Filament\Widgets\AllPostOverview;
use App\Filament\Widgets\AllPostTypeCount;
use App\Filament\Widgets\MyPostOverview;
use App\Filament\Widgets\PostCreationTrend;
use App\Filament\Widgets\MyPostTypeCount;
use App\Filament\Widgets\MyUnpublishedPosts;
use App\Filament\Widgets\UnpublishedPosts;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;

class Dashboard extends BaseDashboard
{
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedHome;

    protected static string | BackedEnum | null $activeNavigationIcon = Heroicon::Home;

    public function getActions(): array
    {
        $actions = [
            Action::make('createPost')
                ->label('New Post')
                ->color('primary')
                ->icon(Heroicon::Plus)
                ->url(fn (): string => PostResource::getUrl('create'))
        ];

        if (auth()->user()->can('View:Dashboard')) {
            $actions[] = OptimizeAction::make('optimize');
        }

        return $actions;
    }

    public function getWidgets(): array
    {
        return [
            AllPostOverview::class,
            PostCreationTrend::class,
            AllPostTypeCount::class,
            UnpublishedPosts::class,

            MyPostOverview::class,
            MyPostTypeCount::class,
            MyUnpublishedPosts::class,
            ];
    }
}
