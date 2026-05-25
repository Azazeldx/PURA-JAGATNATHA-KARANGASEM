<?php

namespace App\Filament\Resources\GeneralSettings\Schemas\Components\SettingTabs;

use App\Enums\GeneralSettingsEnums\SocialNetworkEnum;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;

class SocialNetworkTab extends Tab
{
    public static function get(?string $label = 'Social Network'): static
    {
        $fields = [];
        foreach (SocialNetworkEnum::options() as $key => $value) {
            $fields[] = Fieldset::make(strtolower($value))
                ->label(ucfirst(strtolower($key)))
                ->statePath(strtolower($value))
                ->columnSpan(1)
                ->columns(1)
                ->schema([
                    TextInput::make('label')
                        ->maxLength(255),
                    TextInput::make('url')
                        ->url(),
                ]);
        }

        return parent::make($label)
            ->icon(Heroicon::OutlinedHeart)
            ->schema([
                Grid::make()
                    ->columns([
                        'lg' => 4,
                        'md' => 2
                    ])
                    ->columnSpanFull()
                    ->statePath('social_network')
                    ->schema($fields),
            ]);
    }
}
