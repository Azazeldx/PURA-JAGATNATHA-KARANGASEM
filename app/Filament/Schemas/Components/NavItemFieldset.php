<?php

namespace App\Filament\Schemas\Components;

use App\Enums\GeneralSettingsEnums\NavigationTypeEnum;
use App\Filament\Forms\Components\NavItemTypeSelect;
use App\Models\Page;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;

class NavItemFieldset extends Fieldset
{
    public static function get(?string $label = 'Nav Item', bool|Closure $condition = false): static
    {
        return parent::make($label)
            ->schema([
                NavItemTypeSelect::get(condition: $condition),
                TextInput::make('label')
                    ->required()
                    ->maxLength(50)
                    ->columnSpan(1),
                TextInput::make('url')
                    ->visible(fn ($get) => ($get('type')) == NavigationTypeEnum::Link->value)
                    ->required()
                    ->url()
                    ->columnSpanFull(),
                Select::make('page_id')
                    ->visible(fn ($get) => $get('type') == NavigationTypeEnum::Page->value)
                    ->required()
                    ->columnSpanFull()
                    ->options(Page::pluck('title', 'id')->toArray())
                    ->searchable()
                    ->preload()
            ]);
    }
}
