<?php

namespace App\Filament\Resources\PageSections\Schemas;

use App\Enums\PageEnums\PageRegionEnum;
use App\Enums\PageEnums\PageSectionTypeEnum;
use App\Filament\Schemas\Components\LabelSection;
use App\Filament\Schemas\Components\SchemaTabs\SectionTab;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class PageSectionForm
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
                                Select::make('section_schema.type')
                                    ->options(PageSectionTypeEnum::options())
                                    ->required()
                                    ->live(),
                                Select::make('region')
                                    ->options(PageRegionEnum::options())
                                    ->required()
                                    ->live(),
                            ]),
                    ]),
                Group::make()
                    ->columns(1)
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        LabelSection::get('Section', 50)
                            ->columns(['lg' => 2]),
                        Tabs::make('Schema')
                            ->tabs([
                                SectionTab::get()
                            ])
                    ]),
            ]);
    }
}
