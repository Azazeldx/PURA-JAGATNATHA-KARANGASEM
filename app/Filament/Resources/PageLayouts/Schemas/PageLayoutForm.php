<?php

namespace App\Filament\Resources\PageLayouts\Schemas;

use App\Enums\PageEnums\PageAsideTypeEnum;
use App\Enums\PageEnums\PageRegionEnum;
use App\Filament\Schemas\Components\LabelSection;
use App\Models\PageSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PageLayoutForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(['lg' => 3])
            ->components([
                Group::make()
                    ->columns(1)
                    ->schema([
                        LabelSection::get('Layout', 50, False),
                        Section::make('Region Setting')
                            ->live()
                            ->collapsible()
                            ->statePath('layout_schema.enable')
                            ->schema(function (): array {
                                $item = [];

                                foreach (PageRegionEnum::options() as $value => $label) {
                                    $item[$value] = Toggle::make($value)
                                        ->label($label.' Region');
                                }

                                return $item;
                            }),
                        Section::make('Aside Setting')
                            ->collapsible()
                            ->live()
                            ->statePath('layout_schema.enable')
                            ->visible(fn ($get) => $get('layout_schema.enable.aside'))
                            ->schema([
                                Select::make('aside_type')
                                    ->required(fn ($get) => $get('layout_schema.enable.aside'))
                                    ->options(PageAsideTypeEnum::options()),
                            ]),
                    ]),
                    Section::make('Layout')
                        ->collapsible()
                        ->columns(['lg' => 2])
                        ->columnSpan(['lg' => 2])
                        ->statePath('layout_schema')
                        ->schema(function ($get) {
                            $regions = PageRegionEnum::options();
                            $form = [];

                            // Need Optimized
                            foreach ($regions as $value => $label) {
                                if ($value != PageRegionEnum::Main->value && $value != PageRegionEnum::Aside->value) {
                                    $form[$value] =
                                        Section::make($label)
                                            ->visible(fn ($get) => $get('../layout_schema.enable.'.$value))
                                            ->statePath($value)
                                            ->columnSpanFull()
                                            ->columns(1)
                                            ->schema([
                                                Select::make('section_id')
                                                    ->required()
                                                    ->columnSpanFull()
                                                    ->options(PageSection::where('region', $value)->pluck('title', 'id')->toArray())
                                                    ->searchable()
                                                    ->preload()
                                            ]);
                                } elseif ($value == PageRegionEnum::Aside->value) {
                                    $form['aside_left'] = 
                                        Section::make('Aside Left')
                                            ->visible(fn ($get) => $get('../layout_schema.enable.aside') && $get('../layout_schema.enable.aside_type') != PageAsideTypeEnum::Right->value)
                                            ->statePath('aside_left')
                                            ->columnSpanFull()
                                            ->columns(1)
                                            ->schema([
                                                Select::make('section_id')
                                                    ->required()
                                                    ->columnSpanFull()
                                                    ->options(PageSection::where('region', $value)->pluck('title', 'id')->toArray())
                                                    ->searchable()
                                                    ->preload()
                                            ]);
                                    $form['aside_right'] = 
                                        Section::make('Aside Right')
                                            ->visible(fn ($get) => $get('../layout_schema.enable.'.$value) && $get('../layout_schema.enable.aside_type') != PageAsideTypeEnum::Left->value)
                                            ->statePath('aside_right')
                                            ->columnSpanFull()
                                            ->columns(1)
                                            ->schema([
                                                Select::make('section_id')
                                                    ->required()
                                                    ->columnSpanFull()
                                                    ->options(PageSection::where('region', $value)->pluck('title', 'id')->toArray())
                                                    ->searchable()
                                                    ->preload()
                                            ]);
                                }
                            }

                            return $form;
                        }),
            ]);
    }
}
