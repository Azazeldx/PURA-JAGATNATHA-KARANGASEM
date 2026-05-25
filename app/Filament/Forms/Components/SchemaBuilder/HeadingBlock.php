<?php

namespace App\Filament\Forms\Components\SchemaBuilder;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;

class HeadingBlock extends Block
{
    public static function get(?string $label = 'heading'): static
    {
        return parent::make($label)
			->icon(Heroicon::OutlinedPencil)
			->columns(2)
			->schema([
				TextInput::make('key')
					->label('Key')
					->required(),
				Select::make('level')
					->options([
						'h1' => 'Heading 1',
						'h2' => 'Heading 2',
						'h3' => 'Heading 3',
						'h4' => 'Heading 4',
						'h5' => 'Heading 5',
						'h6' => 'Heading 6',
					])
					->required(),
			]);
    }
}