<?php

namespace App\Filament\Schemas\Components\SchemaTabs;

use App\Filament\Forms\Components\SchemaBuilder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;

class CardTab extends Tab
{
    public static function get(?string $label = 'Card', ?string $path = 'card_schema', ?string $rootView): static
    {
        return parent::make($label)
			->icon(Heroicon::OutlinedRectangleStack)
			->statePath($path)
			->visible(fn($get) => $get($path.'.enable'))
			->schema([
				Grid::make()
					->columns(1)
					->columnSpanFull()
					->schema([
						TextInput::make('view_path')
							->prefix(fn ($get) => 'exryze::card.'.$rootView.'.')
							->formatStateUsing(function ($state) use ($rootView) {
								return str_starts_with($state, 'exryze::card.' . $rootView . '.')
									? substr($state, strlen('exryze::card.' . $rootView . '.'))
									: $state;
							})
							->dehydrateStateUsing(fn ($state, $get) => 'exryze::card.' . $rootView. '.' . $state)
							->required(),
						SchemaBuilder::get()
					])
			]);
    }
}