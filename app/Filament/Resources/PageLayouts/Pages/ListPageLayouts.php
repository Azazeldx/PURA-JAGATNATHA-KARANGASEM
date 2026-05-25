<?php

namespace App\Filament\Resources\PageLayouts\Pages;

use App\Filament\Resources\PageLayouts\PageLayoutResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPageLayouts extends ListRecords
{
    protected static string $resource = PageLayoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
