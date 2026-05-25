<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\PostEnums\PostStatusEnum;
use App\Filament\Schemas\Components\SchemaTabs\MetadataTab;
use App\Filament\Schemas\Components\LabelSection;
use App\Services\PostSchemaResolver;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Forms\RichEditor\AttachCuratorMediaPlugin;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Zvizvi\UserFields\Components\UserSelect;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Wizard::make([
                    Step::make('Setting')
                        ->schema([
                            Section::make('Settings')
                                ->columns(['md' => 2])
                                ->schema([
                                    Select::make('post_type_id')
                                        ->relationship('type', 'title', function ($query) {
                                            if (auth()->user()->hasRole('requester')) {
                                                return $query->whereIn('slug', ['produk', 'umkm']);
                                            }
                                            return $query;
                                        })
                                        ->columnSpan('full')
                                        ->searchable()
                                        ->required()
                                        ->preload()
                                        ->live(),
                                    UserSelect::make('author_id')
                                        ->relationship('author', 'name')
                                        ->visible(false),
                                    Select::make('status')
                                        ->options(PostStatusEnum::options())
                                        ->visible(false),
                                    Select::make('categories')
                                        ->relationship('categories', 'title')
                                        ->multiple()
                                        ->preload()
                                        ->searchable()
                                        ->createOptionForm([
                                            LabelSection::get('Category', 100)
                                                ->columns(['lg' => 2]),
                                        ]),
                                    Select::make('tags')
                                        ->relationship('tags', 'title')
                                        ->multiple()
                                        ->preload()
                                        ->searchable()
                                        ->createOptionForm([
                                            LabelSection::get('Tag', 100)
                                                ->columns(['lg' => 2]),
                                        ]),
                                ])
                        ]),
                    Step::make('Content')
                        ->schema([
                            LabelSection::get('Post')
                                ->columnSpan(['lg' => 2])
                                ->columns(['lg' => 2])
                                ->additionalComponents([
                                    CuratorPicker::make('cover_id')
                                        ->label('Cover')
                                        ->disk('public')
                                        ->directory(fn ($get) => 'media/post/' . PostSchemaResolver::getSlug($get('post_type_id')))
                                        ->columnSpanFull(),
                                    Textarea::make('description')
                                        ->label('Short description')
                                        ->helperText('Usually used in card description text and SEO description fallback.')
                                        ->columnSpanFull(),
                                    RichEditor::make('content')
                                        ->json()
                                        ->columnSpanFull()
                                        ->hidden(fn ($get) => !PostSchemaResolver::PageEnabled($get('post_type_id')))
                                        ->plugins([
                                            AttachCuratorMediaPlugin::make()
                                        ])
                                ]),
                        ]),
                    Step::make('Additional')
                        ->schema(function ($get) {
                            return [
                                Group::make()
                                    ->statePath('card_content.section')
                                    ->schema(PostSchemaResolver::cardSectionSchema($get('post_type_id'))),
                                Group::make()
                                    ->statePath('card_content.aside')
                                    ->schema(PostSchemaResolver::cardAsideSchema($get('post_type_id'))),
                                Tabs::make('Post')
                                    ->columnSpan(['lg' => 2])
                                    ->tabs([
                                        // Tab::make('Section Card')
                                        //     ->icon(Heroicon::OutlinedRectangleStack)
                                        //     ->statePath('card_content.section')
                                        //     ->hidden(fn ($get) => !PostSchemaResolver::cardSectionEnabled($get('post_type_id')))
                                        //     ->schema(fn ($get) => PostSchemaResolver::cardSectionSchema($get('post_type_id'))),
                                        // Tab::make('Aside Card')
                                        //     ->icon(Heroicon::OutlinedRectangleStack)
                                        //     ->statePath('card_content.aside')
                                        //     ->hidden(fn ($get) => !PostSchemaResolver::cardAsideEnabled($get('post_type_id')))
                                        //     ->schema(fn ($get) => PostSchemaResolver::cardAsideSchema($get('post_type_id'))),
                                        // Tab::make('Page')
                                        //     ->icon(Heroicon::OutlinedDocument)
                                        //     ->statePath('page_content')
                                        //     ->hidden(fn ($get) => !PostSchemaResolver::PageEnabled($get('post_type_id')))
                                        //     ->schema([]),
                                        MetadataTab::get()
                                    ])
                            ];
                        }),
                ])
            ]);
    }

    // public static function configure(Schema $schema): Schema
    // {
    //     return $schema
    //         ->columns(['lg' => 3])
    //         ->components([
    //             Group::make()
    //                 ->columnSpan(1)
    //                 ->schema([
    //                     Section::make('Settings')
    //                         ->schema([
    //                             Select::make('post_type_id')
    //                                 ->relationship('type', 'title')
    //                                 ->preload()
    //                                 ->searchable()
    //                                 ->required()
    //                                 ->live(),
    //                             Select::make('status')
    //                                 ->live()
    //                                 ->required()
    //                                 ->options(PostStatusEnum::options()),
    //                             DateTimePicker::make('published_at')
    //                                 ->required(fn($get) => $get('status') == PostStatusEnum::Published->value),
    //                             DateTimePicker::make('highlighted_at'),
    //                             UserSelect::make('author_id')
    //                                 ->label('Author')
    //                                 ->relationship('author', 'name')
    //                                 ->searchable()
    //                                 ->preload(),
    //                         ]),
    //                     Section::make('Attachables')
    //                         ->schema([
    //                             Select::make('categories')
    //                                 ->relationship('categories', 'title')
    //                                 ->multiple()
    //                                 ->preload()
    //                                 ->searchable()
    //                                 ->createOptionForm([
    //                                     LabelSection::get('Category', 100)
    //                                         ->columns(['lg' => 2]),
    //                                 ]),
    //                             Select::make('tags')
    //                                 ->relationship('tags', 'title')
    //                                 ->multiple()
    //                                 ->preload()
    //                                 ->searchable()
    //                                 ->createOptionForm([
    //                                     LabelSection::get('Tag', 100)
    //                                         ->columns(['lg' => 2]),
    //                                 ]),
    //                         ])
    //                 ]),
    //             Group::make()
    //                 ->columns(['lg' => 2])
    //                 ->columnSpan(['lg' => 2])
    //                 ->schema([
    //                     LabelSection::get('Post')
    //                         ->columnSpan(['lg' => 2])
    //                         ->columns(['lg' => 2])
    //                         ->additionalComponents([
    //                             CuratorPicker::make('cover_id')
    //                                 ->label('Cover')
    //                                 ->disk('public')
    //                                 ->directory(fn ($get) => 'media/post/' . PostSchemaResolver::getSlug($get('post_type_id')))
    //                                 ->columnSpanFull(),
    //                             Textarea::make('description')
    //                                 ->label('Short description')
    //                                 ->helperText('Usually used in card description text and SEO description fallback.')
    //                                 ->columnSpanFull(),
    //                             RichEditor::make('content')
    //                                 ->json()
    //                                 ->columnSpanFull()
    //                                 ->plugins([
    //                                     AttachCuratorMediaPlugin::make()
    //                                 ])
    //                         ]),
    //                     Tabs::make('Post')
    //                         ->columnSpan(['lg' => 2])
    //                         ->tabs([
    //                             Tab::make('Section Card')
    //                                 ->icon(Heroicon::OutlinedRectangleStack)
    //                                 ->statePath('card_content.section')
    //                                 ->hidden(fn($get) => !PostSchemaResolver::cardSectionEnabled($get('post_type_id')))
    //                                 ->schema(fn($get) => PostSchemaResolver::cardSectionSchema($get('post_type_id'))),
    //                             Tab::make('Aside Card')
    //                                 ->icon(Heroicon::OutlinedRectangleStack)
    //                                 ->statePath('card_content.aside')
    //                                 ->hidden(fn($get) => !PostSchemaResolver::cardAsideEnabled($get('post_type_id')))
    //                                 ->schema(fn($get) => PostSchemaResolver::cardAsideSchema($get('post_type_id'))),
    //                             Tab::make('Page')
    //                                 ->icon(Heroicon::OutlinedDocument)
    //                                 ->statePath('page_content')
    //                                 ->hidden(fn($get) => !PostSchemaResolver::PageEnabled($get('post_type_id')))
    //                                 ->schema(function ($get) {

    //                                     if (PostSchemaResolver::useBuilder($get('post_type_id'))) {
    //                                         return [
    //                                             Select::make('page_id')
    //                                                 ->label('Select Page Template')
    //                                                 ->options([])
    //                                         ];
    //                                     }

    //                                     return PostSchemaResolver::pageSchema($get('post_type_id'));
    //                                 }),
    //                             MetadataTab::get()
    //                         ])
    //                 ])
    //         ]);
    // }
}
