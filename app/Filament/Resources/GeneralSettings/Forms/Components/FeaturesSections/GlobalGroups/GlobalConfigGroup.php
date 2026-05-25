<?php

namespace App\Filament\Resources\GeneralSettings\Forms\Components\FeaturesSections\GlobalGroups;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class GlobalConfigGroup extends Group
{
    public static function get(): static
    {
        return parent::make()
            ->columns(['lg' => 2])
            ->columnSpan(['lg' => 2])
            ->schema([
                Section::make('Navigation Features')
                    ->icon(Heroicon::ListBullet)
                    ->visible(fn ($get) => ($get('navigation.enable')))
                    ->collapsible()
                    ->collapsed()
                    ->columns(['md' => 2])
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        Toggle::make('navigation.homepage')
                            ->label('Homepage'),
                        Toggle::make('navigation.search')
                            ->label('Search'),
                        Toggle::make('navigation.page_builder')
                            ->disabled(fn ($get) => !$get('page_builder.enable'))
                            ->label('Page Builder')
                            ->helperText('Linked: Global Features - Page Builder'),
                    ])
            ]);
    }
}