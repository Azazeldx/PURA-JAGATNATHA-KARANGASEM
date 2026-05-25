<?php

namespace App\Filament\Resources\PostTypes\Schemas;

use App\Enums\PageEnums\PageRegionEnum;
use App\Filament\Schemas\Components\LabelSection;
use App\Filament\Schemas\Components\SchemaTabs\CardTab;
use App\Filament\Schemas\Components\SchemaTabs\PageTab;
use App\Models\PageLayout;
use App\Models\PageSection;
use App\Services\FeatureService;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class PostTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(['lg' => 3])
            ->components([
                Group::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Cards')
                            ->description('Enable section to load your post as a card.')
                            ->collapsible()
                            ->live()
                            ->schema([
                                Toggle::make('card_schema.section.enable')
                                    ->label('Enable Section Card'),
                                Toggle::make('card_schema.aside.enable')
                                    ->label('Enable Aside Card'),
                            ]),
                        Section::make('Detail Page')
                            ->description('Enable page to load your post detail.')
                            ->collapsible()
                            ->live()
                            ->schema([
                                Toggle::make('page_schema.enable')
                                    ->label('Enable Page Detail'),
                                Toggle::make('page_schema.page_builder')
                                    ->visible(fn ($get) => app(FeatureService::class)->enabled('global.page_builder') && $get('page_schema.enable'))
                                    ->label('Use Page Builder Feature')
                            ]),
                    ]),
                Group::make()
                    ->columns(['lg' => 2])
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        LabelSection::get('Post Type', 50)
                            ->columnSpan(['lg' => 2])
                            ->columns(['lg' => 2]),
                        Tabs::make('Schema')
                            ->columnSpan(['lg' => 2])
                            ->tabs([
                                CardTab::get('Section Card', 'card_schema.section', 'section'),
                                CardTab::get('Aside Card', 'card_schema.aside', 'aside'),
                                PageTab::get()
                            ])
                    ]),
            ]);
    }
}
