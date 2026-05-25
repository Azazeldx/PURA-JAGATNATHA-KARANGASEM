<?php

namespace App\Filament\Resources\GeneralSettings\Forms\Components\SiteSections;

use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class LocationSection extends Section
{
    public static function get(?string $label = 'Location'): static
    {
        return parent::make($label)
            ->columns(1)
            ->columnSpan(['lg' => 2])
            ->statePath('location')
            ->schema([
                TextInput::make('address')
                    ->maxLength(255),
                TextInput::make('url')
                    ->label('Maps URL')
                    ->url()
                    ->maxLength(255),
                Map::make('coordinate')
                    ->zoom(15)
                    ->minZoom(0)
                    ->maxZoom(28)
                    ->tilesUrl("https://tile.openstreetmap.de/{z}/{x}/{y}.png")
                    ->detectRetina(true)
                    ->showFullscreenControl(true)
                    ->showZoomControl(true)
                    ->extraStyles(['min-height: 50dvh']),
            ]);
    }
}