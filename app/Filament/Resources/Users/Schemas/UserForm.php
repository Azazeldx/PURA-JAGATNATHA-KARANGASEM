<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(['lg' => 3])
            ->components([
                Group::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Roles')
                            ->schema([
                                // Using Select Component
                                Select::make('roles')
                                ->relationship('roles', 'name')
                                ->multiple()
                                ->preload()
                                ->searchable(),
                                            
                                // Using CheckboxList Component
                                // CheckboxList::make('roles')
                                //     ->relationship('roles', 'name')
                                //     ->searchable(),
                            ])
                    ]),
                Group::make()
                    ->columns(1)
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        Section::make('Identification')
                            ->columns(['lg' => 2])
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('email')
                                    ->label('Email address')
                                    ->email()
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('password')
                                    ->label('Password')
                                    ->confirmed()
                                    ->password()
                                    ->required()
                                    // ->rule(Password::min(8))
                                        // ->mixedCase()
                                        // ->numbers()
                                        // ->symbols()
                                        // ->uncompromised())
                                    ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                                    ->autocomplete('new-password')
                                    ->revealable(filament()->arePasswordsRevealable())
                                    ->hiddenOn('edit')
                                    ->columnSpan(1),
                                TextInput::make('password_confirmation')
                                    ->label('Confirm Password')
                                    ->password()
                                    ->required()
                                    ->dehydrated(false)
                                    ->autocomplete('new-password')
                                    ->revealable(filament()->arePasswordsRevealable())
                                    ->hiddenOn('edit')
                                    ->columnSpan(1),
                            ])
                    ])
            ]);
    }
}
