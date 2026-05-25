<?php

namespace App\Filament\Schemas\Components\SchemaTabs;

use App\Filament\Schemas\Components\MetadataTabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;

class MetadataTab extends Tab
{
    public static function get(?string $label = 'SEO', ?string $path = 'metadata'): static
    {
        return parent::make($label)
            ->icon(Heroicon::Megaphone)
            ->statePath($path)
            ->schema([
                MetadataTabs::get()
            ]);
    }
}