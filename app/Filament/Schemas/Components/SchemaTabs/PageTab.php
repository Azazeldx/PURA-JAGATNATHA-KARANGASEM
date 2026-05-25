<?php

namespace App\Filament\Schemas\Components\SchemaTabs;

use App\Filament\Forms\Components\SchemaBuilder;
use App\Models\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;

class PageTab extends Tab
{
    public static function get(?string $label = 'Page', ?string $path = 'page_schema'): static
    {
        return parent::make($label)
			->icon(Heroicon::OutlinedDocument)
			->statePath($path)
			->visible(fn($get) => $get($path.'.enable'))
			->schema([
				Grid::make()
					->columns(1)
					->columnSpanFull()
					->schema([
						Select::make('page_id')
							->required()
							->options(Page::whereNull('published_at')->pluck('title', 'id')->toArray())
							->visible(fn($get) => $get('../'.$path.'.page_builder')),
						TextInput::make('view_path')
							->visible(fn($get) => !$get('../'.$path.'.page_builder')),
						SchemaBuilder::get(),
					])
			]);
    }
}