<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Enums\PostEnums\PostStatusEnum;
use App\Filament\Resources\Posts\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return [
            ...$data,
            'author_id' => auth('web')->id(),
            'status' => PostStatusEnum::Draft->value,
        ];
    }
}
