<?php

namespace App\Filament\Schemas\Components;

use App\Filament\Schemas\Components\MetadataTabs\BasicTab;
use App\Filament\Schemas\Components\MetadataTabs\OpenGraphTab;
use App\Filament\Schemas\Components\MetadataTabs\RobotsTab;
use App\Filament\Schemas\Components\MetadataTabs\TwitterTab;
use Filament\Schemas\Components\Tabs;

class MetadataTabs extends Tabs
{
    public static function get(?string $label = 'SEO'): static
    {
        return parent::make($label)
			->columns(1)
			->columnSpanFull()
			->vertical()
			->tabs([
				BasicTab::get(),
				RobotsTab::get(),
				OpenGraphTab::get(),
				TwitterTab::get()
			]);
    }
}