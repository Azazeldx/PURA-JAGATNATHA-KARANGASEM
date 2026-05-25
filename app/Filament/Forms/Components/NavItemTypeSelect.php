<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Select;
use App\Enums\GeneralSettingsEnums\NavigationTypeEnum;
use Closure;

class NavItemTypeSelect extends Select
{
    public static function get(string $label = 'type', bool|Closure $condition = false): static
    {
        return parent::make($label)
            ->label('Type')
            ->options(function ($get) use ($condition) {

                $result = $condition instanceof Closure
                    ? $condition($get)
                    : $condition;

                return $result
                    ? NavigationTypeEnum::options()
                    : [
                        NavigationTypeEnum::Link->value =>
                        NavigationTypeEnum::Link->name,
                    ];
            })
			->columnSpan(1)
            ->required()
            ->live();
    }
}