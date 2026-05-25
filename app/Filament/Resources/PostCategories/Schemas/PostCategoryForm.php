<?php

namespace App\Filament\Resources\PostCategories\Schemas;

use App\Filament\Schemas\Components\LabelSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(['lg' => 3])
            ->components([
                Group::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Settings')
                            ->schema([
                                Select::make('parent_id')
                                    ->searchable()
                                    ->preload()
                                    ->relationship('parent', 'title', ignoreRecord: true)
                                    ->createOptionForm([
                                        LabelSection::get('Category', 100)
                                            ->columns(['lg' => 2]),
                                    ])
                            ])
                    ]),
                Group::make()
                    ->columns(1)
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        LabelSection::get('Category', 100)
                            ->columns(['lg' => 2]),
                    ])
            ]);
    }
}
