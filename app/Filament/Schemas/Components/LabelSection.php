<?php

namespace App\Filament\Schemas\Components;

use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

class LabelSection extends Section
{
    protected array $baseComponents = [];

    public static function get(?string $label = 'Label', int|Closure|null $lenght = null, bool $slug = True): static
    {
        $titleInput = TextInput::make('title')
            ->required()
            ->columnSpan(!$slug ? 'full' : 1)
            // ->columnSpanFull(!$slug)
            ->maxLength($lenght)
            ->live(onBlur: true)
            ->unique(ignoreRecord: true)
            ->afterStateUpdated(fn($set, $state) => $set('slug', Str::slug($state)));

        $slugInput = TextInput::make('slug')
            ->required()
            ->visible($slug)
            ->maxLength($lenght)
            ->live(onBlur: true)
            ->unique(ignoreRecord: true)
            ->helperText('Auto-generated from title, but can be edited');

        $schema = [$titleInput, $slugInput];

        $section = parent::make($label)->schema($schema);
        $section->baseComponents = $schema;

        return $section;
    }

    public function additionalComponents(array|Closure $components): static
    {
        $additional = $components instanceof Closure ? $components() : $components;
        $currentSchema = $this->baseComponents;
        $newSchema = array_merge($currentSchema, $additional);
        return $this->schema($newSchema);
    }
}