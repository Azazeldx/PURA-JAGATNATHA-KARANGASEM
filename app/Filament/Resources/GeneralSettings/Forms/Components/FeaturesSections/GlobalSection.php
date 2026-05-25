<?php

namespace App\Filament\Resources\GeneralSettings\Forms\Components\FeaturesSections;

use App\Filament\Resources\GeneralSettings\Forms\Components\FeaturesSections\GlobalGroups\GlobalConfigGroup;
use App\Filament\Resources\GeneralSettings\Forms\Components\FeaturesSections\GlobalGroups\GlobalEnableGroup;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class GlobalSection extends Section
{
    public static function get(?string $label = 'Global Features'): static
    {
        return parent::make($label)
            ->icon(Heroicon::OutlinedGlobeAlt)
            ->statePath('global')
            ->collapsible()
            ->columns(['lg' => 3])
            ->columnSpan(1)
            ->schema([
                GlobalEnableGroup::get(),
                GlobalConfigGroup::get()
            ]);
    }
}