<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Enums\PageEnums\PageAsideTypeEnum;
use App\Enums\PageEnums\PageRegionEnum;
use App\Enums\PageEnums\PageSectionTypeEnum;
use App\Filament\Schemas\Components\LabelSection;
use App\Filament\Schemas\Components\SchemaTabs\MetadataTab;
use App\Models\PageLayout;
use App\Models\PageSection;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PageForm
{
    private static function sectionContentResolver(array $section) : array 
    {
        $fields = [];
        $isVisionMissionSection = data_get($section, 'view_path') === 'dynamic.main.vision-mission';
        $labelMap = [
            'area' => 'Berdiri Sejak',
            'population' => 'Rata-rata Pemedek',
            'neighborhood' => 'Jumlah Pemangku',
            'family' => 'Jadwal Piodalan',
        ];
        
        switch ($section['type']) {
            case PageSectionTypeEnum::Static->value:
                # code...
                break;

            case PageSectionTypeEnum::Dynamic->value:

                // Field Resolver
                foreach ($section['schema'] as $block) {
                    $key = $block['data']['key'];

                    // For the vision-mission section we will manage mission list
                    // with a dedicated repeater, so hide legacy mission text fields.
                    if ($isVisionMissionSection && in_array($key, ['missions_0', 'missions_1', 'missions_2'])) {
                        continue;
                    }

                    switch ($block['type']) {
                        case 'image':
                            if ($key === 'profile') {
                                // allow switching between image or video URL for profile
                                $fields['profile_type'] = Select::make('profile_type')
                                    ->options([
                                        'image' => 'Gambar',
                                        'video' => 'Video',
                                    ])
                                    ->default('image')
                                    ->columnSpanFull();

                                $fields['profile'] = CuratorPicker::make('profile')
                                    ->disk('public')
                                    ->directory('media/section')
                                    ->required()
                                    ->visible(fn ($get) => $get('profile_type') === 'image');

                                $fields['profile_video'] = TextInput::make('profile_video')
                                    ->label('YouTube URL')
                                    ->visible(fn ($get) => $get('profile_type') === 'video');
                            } else {
                                $fields[$key] = 
                                    CuratorPicker::make($key)
                                        ->disk('public')
                                        ->directory('media/section')
                                        ->required();
                            }
                            break;
                        case 'heading':
                            $input = TextInput::make($key)
                                ->required();
                            if (isset($labelMap[$key])) {
                                $input->label($labelMap[$key]);
                            }
                            $fields[$key] = $input;
                            break;
                        case 'paragraph':
                            $textarea = Textarea::make($key)
                                ->required();
                            if (isset($labelMap[$key])) {
                                $textarea->label($labelMap[$key]);
                            }
                            $fields[$key] = $textarea;
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                }

                if ($isVisionMissionSection) {
                    $fields['vision_title'] = TextInput::make('vision_title')
                        ->label('Judul Bagian Visi')
                        ->required();

                    $fields['mission_title'] = TextInput::make('mission_title')
                        ->label('Judul Bagian Misi')
                        ->default('Langkah Kerja Utama')
                        ->required();

                    $fields['visions'] = Repeater::make('visions')
                        ->label('Daftar Visi')
                        ->defaultItems(1)
                        ->reorderable()
                        ->addActionLabel('Tambah Visi')
                        ->schema([
                            Textarea::make('text')
                                ->label('Isi Visi')
                                ->rows(2)
                                ->required(),
                        ])
                        ->columnSpanFull();

                    $fields['missions'] = Repeater::make('missions')
                        ->label('Daftar Misi')
                        ->defaultItems(1)
                        ->reorderable()
                        ->addActionLabel('Tambah Misi')
                        ->schema([
                            Textarea::make('text')
                                ->label('Isi Misi')
                                ->rows(2)
                                ->required(),
                        ])
                        ->columnSpanFull();
                }
                break;

            case PageSectionTypeEnum::Builder->value:
                # code...
                break;
            
            default:
                # code...
                break;
        }

        return $fields;
    }

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
                                Select::make('page_layout_id')
                                    ->relationship('layout', 'title')
                                    ->preload()
                                    ->searchable()
                                    ->required()
                                    ->live(),
                            ]),
                        Section::make('Main Sections')
                            ->schema([
                                Repeater::make('sections')
                                    ->hiddenLabel()
                                    ->statePath('page_content.' . PageRegionEnum::Main->value)
                                    ->live()
                                    ->schema([
                                        // Need optimized
                                        Select::make('section_id')
                                            ->required()
                                            ->columnSpanFull()
                                            ->options(PageSection::where('region', PageRegionEnum::Main->value)->pluck('title', 'id')->toArray())
                                            ->searchable()
                                            ->preload()
                                    ])
                            ])
                    ]),
                Group::make()
                    ->columns(1)
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        LabelSection::get('Post', 50)
                            ->columns(['lg' => 2]),
                        Tabs::make('Page')
                            ->tabs(function ($get) {
                                $form = [];
                                
                                if ($get('page_layout_id')) {
                                    $schema = PageLayout::where('id', $get('page_layout_id'))->firstOrFail('layout_schema')->layout_schema;
                                    $regions = [];

                                    foreach ($schema['enable'] as $region => $enable) {
                                        if (!$enable) continue;

                                        switch ($region) {
                                            case PageRegionEnum::Main->value:
                                                if ($get('page_content.' . $region)) {
                                                    foreach ($get('page_content.' . PageRegionEnum::Main->value) as $key => $data) {
                                                        $sectionId = data_get($data, 'section_id');

                                                        if (! $sectionId) {
                                                            continue;
                                                        }

                                                        $section = PageSection::where('id', $sectionId)->first(['slug', 'section_schema']);

                                                        if (is_null($section)) continue;

                                                        $regions[$region][$key] = $section->section_schema;

                                                        $fields[$key] = Tab::make(ucfirst($section->slug))
                                                            ->statePath($key)
                                                            ->schema(self::sectionContentResolver($regions[$region][$key]));

                                                        $form[$region] = 
                                                            Tab::make(ucfirst($region))
                                                                ->statePath('page_content.'.$region)
                                                                ->schema([
                                                                    Tabs::make()
                                                                        ->columns(1)
                                                                        ->columnSpanFull()
                                                                        ->vertical()
                                                                        ->schema($fields)
                                                                ]);
                                                    }
                                                }
                                                break;

                                            case PageRegionEnum::Aside->value:
                                                $type = data_get($schema, 'enable.aside_type');

                                                switch ($type) {
                                                    case PageAsideTypeEnum::Left->value:
                                                        $asides = ['aside_left'];
                                                        break;

                                                    case PageAsideTypeEnum::Right->value:
                                                        $asides = ['aside_right'];
                                                        break;

                                                    default:
                                                        $asides = ['aside_left', 'aside_right'];
                                                        break;
                                                }

                                                foreach ($asides as $aside) {
                                                    $regions[$aside] = PageSection::where('id', data_get($schema, $aside.'.section_id'))->first('section_schema');

                                                    if (is_null($regions[$aside])) continue;

                                                    $fields = self::sectionContentResolver($regions[$aside]->section_schema);

                                                    if (!empty($fields)) {
                                                        $form[$aside] =
                                                            Tab::make(ucfirst($aside))
                                                                ->statePath('page_content.'.$aside)
                                                                ->schema($fields);
                                                    }
                                                }
                                                break;
                                            
                                            default:
                                                if ($region == 'aside_type') break;

                                                $regions[$region] = PageSection::where('id', data_get($schema, $region.'.section_id'))->first('section_schema');

                                                if (is_null($regions[$region])) break;

                                                $fields = self::sectionContentResolver($regions[$region]->section_schema);

                                                if (!empty($fields)) {
                                                    $form[$region] =
                                                        Tab::make(ucfirst($region))
                                                            ->statePath('page_content.'.$region)
                                                            ->schema($fields);
                                                }
                                                break;
                                        }
                                    }
                                }
                                
                                $form[] = MetadataTab::get();

                                return $form;
                            })
                    ])
            ]);
    }
}
