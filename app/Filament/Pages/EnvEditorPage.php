<?php

namespace App\Filament\Pages;

use App\Filament\Actions\OptimizeAction;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Support\Icons\Heroicon;
use GeoSot\FilamentEnvEditor\Pages\ViewEnv as BaseViewEnvEditor;
use UnitEnum;

class EnvEditorPage extends BaseViewEnvEditor
{
    use HasPageShield;

    // protected static ?string $slug = 'environment';

    // protected static ?string $title = 'Environment';

    // protected static ?string $navigationLabel = 'Environment';

    // protected static string|UnitEnum|null $navigationGroup = 'Settings';

    // protected static ?int $navigationSort  = 1;

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::Cog6Tooth;

    protected function getHeaderActions(): array
    {
        return [
            OptimizeAction::make('optimize')
        ];
    }
}
