<?php

namespace App\Filament\Resources\GeneralSettings\Schemas;

use App\Filament\Resources\GeneralSettings\Schemas\Components\SettingTabs\ApplicationTab;
use App\Filament\Resources\GeneralSettings\Schemas\Components\SettingTabs\EmailTab;
use App\Filament\Resources\GeneralSettings\Schemas\Components\SettingTabs\FeaturesTab;
use App\Filament\Resources\GeneralSettings\Schemas\Components\SettingTabs\NavigationTab;
use App\Filament\Resources\GeneralSettings\Schemas\Components\SettingTabs\SocialNetworkTab;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class GeneralSettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->statePath('setting')
            ->components([
                Tabs::make('Setting')
                    ->tabs([
                        ApplicationTab::get(),
                        SocialNetworkTab::get(),
                        FeaturesTab::get(),
                        EmailTab::get(),
                        NavigationTab::get()
                    ]),
            ]);
    }
}
