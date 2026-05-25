<?php

namespace App\Filament\Forms\Components\SchemaBuilder;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;

class ImageBlock extends Block
{
    public static function get(?string $label = 'image'): static
    {
        return parent::make($label)
			->icon(Heroicon::OutlinedPhoto)
			->schema([
				TextInput::make('key')
					->label('Key')
					->required(),
			]);
    }
}