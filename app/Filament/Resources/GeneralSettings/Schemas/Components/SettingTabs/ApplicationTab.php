<?php

namespace App\Filament\Resources\GeneralSettings\Schemas\Components\SettingTabs;

use App\Filament\Resources\GeneralSettings\Forms\Components\SiteSections\ContactsSection;
use App\Filament\Resources\GeneralSettings\Forms\Components\SiteSections\LocationSection;
use App\Filament\Resources\GeneralSettings\Forms\Components\SiteSections\SiteSection;
use App\Filament\Resources\GeneralSettings\Forms\Components\SiteSections\ThemeSection;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;

class ApplicationTab extends Tab
{
    public static function get(?string $label = 'Application'): static
    {
        return parent::make($label)
            ->icon(Heroicon::OutlinedTv)
            ->columns(['lg' => 3])
            ->columnSpanFull()
            ->schema([
                SiteSection::get(),
                LocationSection::get(),
                Grid::make()
                    ->columns(1)
                    ->columnSpan(1)
                    ->schema([
                        ContactsSection::get(),
                        ThemeSection::get(),
                    ])
            ]);
    }
}
