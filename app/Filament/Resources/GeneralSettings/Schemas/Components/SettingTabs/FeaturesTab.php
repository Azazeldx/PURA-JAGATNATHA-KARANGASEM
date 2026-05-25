<?php

namespace App\Filament\Resources\GeneralSettings\Schemas\Components\SettingTabs;

use App\Filament\Resources\GeneralSettings\Forms\Components\FeaturesSections\GlobalSection;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;

class FeaturesTab extends Tab
{
    public static function get(?string $label = 'Features'): static
    {
        return parent::make($label)
            ->icon(Heroicon::OutlinedPuzzlePiece)
            ->statePath('features')
            ->columnSpanFull()
            ->columns(1)
            ->live()
            ->schema([
                GlobalSection::get()
            ]);
    }
}
