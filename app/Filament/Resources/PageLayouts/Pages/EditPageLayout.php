<?php

namespace App\Filament\Resources\PageLayouts\Pages;

use App\Filament\Resources\PageLayouts\PageLayoutResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPageLayout extends EditRecord
{
    protected static string $resource = PageLayoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
