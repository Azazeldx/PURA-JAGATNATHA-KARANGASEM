<?php

namespace App\Filament\Schemas\Components\MetadataTabs;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs\Tab;

class OpenGraphTab extends Tab
{
    public static function get(?string $label = 'Open graph'): static
    {
        return parent::make($label)
			->columns(['lg' => 2])
			->columnSpanFull()
			->statePath('open_graph')
			->schema([
				TextInput::make('title')
					->label('OG Title'),
				Select::make('type')
					->options([
						'article' => 'Article',
						'website' => 'Website',
					])
					->default('article'),
				CuratorPicker::make('image')
					->label('OG Image')
					->columnSpanFull(),
				Textarea::make('description')
					->columnSpanFull()
					->rows(3)
					->maxLength(160),
			]);
    }
}