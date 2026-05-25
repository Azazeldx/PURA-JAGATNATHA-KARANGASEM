<?php

namespace App\Filament\Resources\GeneralSettings\Forms\Components\SiteSections;

use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Components\Section;

class ThemeSection extends Section
{
    public static function get(?string $label = 'Theme'): static
    {
        return parent::make($label)
            ->columns(1)
            ->columnSpan(1)
            ->statePath('theme')
            ->schema([
                ColorPicker::make('primary')
                    ->rgb()
                    ->regex('/^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/'),
                ColorPicker::make('secondary')
                    ->rgb()
                    ->regex('/^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/'),
            ]);
    }
}