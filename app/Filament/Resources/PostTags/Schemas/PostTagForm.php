<?php

namespace App\Filament\Resources\PostTags\Schemas;

use App\Filament\Schemas\Components\LabelSection;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PostTagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                LabelSection::get('Tag', 100)
                    ->columns(['lg' => 2]),
            ]);
    }
}
