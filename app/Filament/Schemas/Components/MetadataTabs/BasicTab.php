<?php

namespace App\Filament\Schemas\Components\MetadataTabs;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs\Tab;

class BasicTab extends Tab
{
    public static function get(?string $label = 'Basic'): static
    {
        return parent::make($label)
			->columns(['lg' => 2])
			->columnSpanFull()
			->statePath('basic')
			->schema([
				TextInput::make('title')
					->label('Meta Title'),
				TextInput::make('keywords')
					->helperText('Comma separated')
					->dehydrateStateUsing(fn ($state) => 
						collect(explode(',', $state))
							->map(fn ($k) => trim(strtolower($k)))
							->filter()
							->unique()
							->values()
							->toArray()
					)
					->formatStateUsing(fn ($state) =>
						is_array($state) ? implode(', ', $state) : $state
					),
				TextInput::make('canonical')
					->label('Canonical URL')
					->columnSpanFull()
					->url(),
				Textarea::make('description')
					->columnSpanFull()
					->rows(3)
					->maxLength(160)
			]);
    }
}