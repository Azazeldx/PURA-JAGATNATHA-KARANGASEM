<?php

namespace App\Filament\Schemas\Components\SchemaTabs;

use App\Enums\PageEnums\PageSectionTypeEnum;
use App\Filament\Forms\Components\SchemaBuilder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;

class SectionTab extends Tab
{
    public static function get(?string $label = 'Section', ?string $path = 'section_schema'): static
    {
        return parent::make($label)
			->icon(Heroicon::OutlinedRectangleGroup)
			->statePath($path)
			->schema([
				Grid::make()
					->columns(1)
					->columnSpanFull()
					->schema([
						TextInput::make('view_path')
							->visible(fn ($get) => $get('type') != PageSectionTypeEnum::Builder->value)
							->prefix(fn ($get) => $get('../section_schema.type') . '.' . $get('../region') . '.')
							->formatStateUsing(function ($state, $get) {
								$type = $get('../section_schema.type'); // Please validate
								$region = $get('../region');

								if (!$type || !$region || !$state) return $state;

								return str_starts_with($state, $type . '.' . $region . '.')
									? substr($state, strlen($type . '.' . $region . '.'))
									: $state;
							})
							->dehydrateStateUsing(fn ($state, $get) => $get('../section_schema.type') . '.' . $get('../region') . '.' . $state)
							->required(),
						SchemaBuilder::get()
							->visible(fn ($get) => $get('type') == PageSectionTypeEnum::Dynamic->value)
					])
			]);
    }
}