<?php

namespace App\Filament\Resources\GeneralSettings\Forms\Components\SiteSections;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class ContactsSection extends Section
{
    public static function get(?string $label = 'Contacts'): static
    {
        return parent::make($label)
            ->columns(1)
            ->columnSpan(1)
            ->statePath('contacts')
            ->schema([
                TextInput::make('email')
                    ->email()
                    ->prefixIcon('heroicon-o-envelope'),
                TextInput::make('phone')
                    ->prefixIcon('heroicon-o-phone'),
            ]);
    }
}