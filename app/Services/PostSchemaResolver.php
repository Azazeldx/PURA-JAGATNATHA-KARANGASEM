<?php

namespace App\Services;

use App\Models\PostType;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class PostSchemaResolver
{
    public static function getType(?int $typeId): ?PostType
    {
        return $typeId ? PostType::find($typeId) : null;
    }

    public static function getSlug(?int $typeId): string
    {
        return self::getType($typeId)?->slug ?? null;
    }

    public static function cardSectionEnabled(?int $typeId): bool
    {
        return data_get(self::getType($typeId)?->card_schema, 'section.enable') ?? false;
    }
    
    public static function cardAsideEnabled(?int $typeId): bool
    {
        return data_get(self::getType($typeId)?->card_schema, 'aside.enable') ?? false;
    }

    public static function pageEnabled(?int $typeId): bool
    {
        return self::getType($typeId)?->page_schema['enable'] ?? false;
    }

    public static function useBuilder(?int $typeId): bool
    {
        return self::getType($typeId)?->page_schema['type'] ?? false;
    }

    public static function cardAsideSchema(?int $typeId): array
    {
        $type = self::getType($typeId);
        $section = $type->card_schema['aside'] ?? [];
        $fields = [];

        if (empty($section)) {
            return [
                Hidden::make(($type->slug ?? 'type').'.empty')
                    ->dehydrated(false),
            ];
        }

        foreach ($section['schema'] as $block) {
            $key = $block['data']['key'];

            switch ($block['type']) {
                case 'image':
                    $fields[$key] = 
                        CuratorPicker::make($key)
                            ->disk('public')
                            ->directory('media/post/'.$type->slug)
                            ->required();
                    break;
                case 'heading':
                    $fields[$key] = 
                        TextInput::make($key)
                            ->required();
                    break;
                case 'paragraph':
                    $fields[$key] = 
                        Textarea::make($key)
                            ->required();
                    break;
                
                default:
                    # code...
                    break;
            }
        }

        return $fields;
    }

    public static function cardSectionSchema(?int $typeId): array
    {
        $type = self::getType($typeId);
        $section = $type->card_schema['section'] ?? [];
        $fields = [];

        if (empty($section)) {
            return [
                Hidden::make('__aside_placeholder')
                    ->dehydrated(false),
            ];
        }

        foreach ($section['schema'] as $block) {
            $key = $block['data']['key'];

            switch ($block['type']) {
                case 'image':
                    $fields[$key] = 
                        CuratorPicker::make($key)
                            ->disk('public')
                            ->directory('media/post/'.$type->slug)
                            ->required();
                    break;
                case 'heading':
                    $fields[$key] = 
                        TextInput::make($key)
                            ->required();
                    break;
                case 'paragraph':
                    $fields[$key] = 
                        Textarea::make($key)
                            ->required();
                    break;
                
                default:
                    # code...
                    break;
            }
        }

        return $fields;
    }

    public static function pageSchema(?int $typeId): array
    {
        return [];
        // return StaticSchemaForm::map(
        //     self::getType($typeId)?->page_schema['schema'] ?? []
        // );
    }
}