<?php

namespace App\Filament\Resources\GeneralSettings\Forms\Components\FeaturesSections\GlobalGroups;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class GlobalEnableGroup extends Group
{
    public static function get(): static
    {
        return parent::make()
            ->columns(1)
            ->columnSpan(1)
            ->schema([
                Section::make('Features')
                    ->icon(Heroicon::OutlinedPuzzlePiece)
                    ->collapsible()
                    ->columns(1)
                    ->columnSpanFull()
                    ->schema([
                        Toggle::make('mail.enable')
                            ->disabled()
                            ->label('Mail Setting'),
                        Toggle::make('navigation.enable')
                            ->label('Navigation Setting'),
                        Toggle::make('page_builder.enable')
                            ->label('Page Builder'),
                    ])
            ]);
    }
}