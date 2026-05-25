<?php

namespace App\Filament\Resources\GeneralSettings\Schemas\Components\SettingTabs;

use App\Filament\Schemas\Components\NavItemFieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;

class NavigationTab extends Tab
{
    public static function get(?string $label = 'Navigation'): static
    {
        return parent::make($label)
            ->icon(Heroicon::ListBullet)
            ->visible(fn ($get) => $get('features.global.navigation.enable'))
            ->schema([
                Grid::make()
                    ->columns(['lg' => 3])
                    ->columnSpanFull()
                    ->statePath('navigation')
                    ->schema([
                        Group::make()
                            ->columns(1)
                            ->columnSpan(1)
                            ->schema([
                                Section::make('Homepage')
                                    ->visible(fn ($get) => $get('../features.global.navigation.homepage'))
                                    ->statePath('home')
                                    ->schema([
                                        Toggle::make('show')
                                            ->label('Show in Navigation'),
                                        NavItemFieldset::get(condition: fn($get) => $get('../../features.global.navigation.page_builder'))
                                            ->columns(1)
                                    ]),
                                Section::make('Search Page')
                                    ->visible(fn ($get) => $get('../features.global.navigation.search'))
                                    ->statePath('search')
                                    ->schema([
                                        NavItemFieldset::get(condition: fn($get) => $get('../../features.global.navigation.page_builder'))
                                            ->columns(1)
                                    ]),
                            ]),
                        Repeater::make('nav_items')
                            ->hiddenLabel()
                            ->columns(1)
                            ->columnSpan(['lg' => 2])
                            ->reorderable(true)
                            ->reorderableWithButtons(true)
                            ->reorderableWithDragAndDrop(true)
                            ->schema([
                                NavItemFieldset::get(condition: fn($get) => $get('../../../features.global.navigation.page_builder'))
                                    ->columns(['md' => 2])
                            ])
                    ]),
            ]);
    }
}
