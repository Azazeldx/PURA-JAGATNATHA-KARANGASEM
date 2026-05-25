<?php

namespace App\Filament\Forms\Components;

use App\Filament\Forms\Components\SchemaBuilder\HeadingBlock;
use App\Filament\Forms\Components\SchemaBuilder\ImageBlock;
use App\Filament\Forms\Components\SchemaBuilder\ParagraphBlock;
use App\Filament\Forms\Components\SchemaBuilder\PostCardBlock;
use Filament\Forms\Components\Builder;

class SchemaBuilder extends Builder
{
    public static function get(?string $label = 'schema'): static
    {
        return parent::make($label)
			->blockNumbers(false)
			->blocks([
				HeadingBlock::get(),
				ParagraphBlock::get(),
				ImageBlock::get(),
				PostCardBlock::get(),
			]);
    }
}