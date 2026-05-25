<?php

namespace App\Filament\Forms\Components\SchemaBuilder;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;

class ParagraphBlock extends Block
{
    public static function get(?string $label = 'paragraph'): static
    {
        return parent::make($label)
			->icon(Heroicon::Bars3BottomLeft)
			->schema([
				TextInput::make('key')
					->label('Key')
					->required(),
			]);
    }
}