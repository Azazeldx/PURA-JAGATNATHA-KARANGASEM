<?php

namespace App\Filament\Schemas\Components\MetadataTabs;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs\Tab;

class TwitterTab extends Tab
{
    public static function get(?string $label = 'Twitter'): static
    {
        return parent::make($label)
			->columns(['lg' => 2])
			->columnSpanFull()
			->statePath('twitter')
			->schema([
				TextInput::make('title')
					->label('Twitter Title'),
				Select::make('card')
					->options([
						'summary' => 'Summary',
						'summary_large_image' => 'Large Image',
					])
					->default('summary_large_image'),
				CuratorPicker::make('image')
					->label('Twitter Image')
					->columnSpanFull(),
				Textarea::make('description')
					->columnSpanFull()
					->rows(3)
					->maxLength(160),
			]);
    }
}