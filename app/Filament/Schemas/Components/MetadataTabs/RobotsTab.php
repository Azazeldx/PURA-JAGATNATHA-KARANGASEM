<?php

namespace App\Filament\Schemas\Components\MetadataTabs;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs\Tab;

class RobotsTab extends Tab
{
    public static function get(?string $label = 'Robots'): static
    {
        return parent::make($label)
			->columns(['lg' => 2])
			->columnSpanFull()
			->statePath('robots')
			->schema([
				Toggle::make('index')
					->default(true),
				Toggle::make('follow')
					->default(true),
			]);
    }
}