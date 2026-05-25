<?php

namespace App\Filament\Forms\Components\SchemaBuilder;

use App\Enums\PageEnums\PageSectionLoaderEnum;
use App\Enums\PageEnums\PageSectionPaginateEnum;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\PostType;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Support\Icons\Heroicon;

class PostCardBlock extends Block
{
    public static function get(?string $label = 'posts'): static
    {
        return parent::make($label)
			->icon(Heroicon::OutlinedRectangleStack)
			->schema([
				TextInput::make('key')
					->label('Key')
					->required(),
				TextInput::make('take')
					->label('Content Loaded')
					->numeric()
					->step(1)
					->minValue(1)
					->maxValue(32)
					->required(),
				Select::make('post_type_id')
					->options(PostType::query()->pluck('title', 'id'))
					->searchable()
					->required(),
				Select::make('paginate')
					->options(PageSectionPaginateEnum::options())
					->default(PageSectionPaginateEnum::None->value)
					->selectablePlaceholder(false)
					->required(),
				Select::make('reference')
					->options(PageSectionLoaderEnum::options())
					->default(PageSectionLoaderEnum::None->value)
					->selectablePlaceholder(false)
					->required()
					->live(),

				Group::make()
					->visible(fn ($get) => $get('reference') == PageSectionLoaderEnum::Defined->value)
					->schema([
						Select::make('post_categories')
							->options(PostCategory::query()->pluck('title', 'id'))
							->multiple()
							->searchable(),
						Select::make('post_tags')
							->options(PostTag::query()->pluck('title', 'id'))
							->multiple()
							->searchable(),
					]),
			]);
    }
}
