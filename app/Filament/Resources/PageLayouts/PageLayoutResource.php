<?php

namespace App\Filament\Resources\PageLayouts;

use App\Filament\Resources\PageLayouts\Pages\CreatePageLayout;
use App\Filament\Resources\PageLayouts\Pages\EditPageLayout;
use App\Filament\Resources\PageLayouts\Pages\ListPageLayouts;
use App\Filament\Resources\PageLayouts\Schemas\PageLayoutForm;
use App\Filament\Resources\PageLayouts\Tables\PageLayoutsTable;
use App\Models\PageLayout;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class PageLayoutResource extends Resource
{
    protected static ?string $slug = 'page/layouts';

    protected static ?string $model = PageLayout::class;

    protected static string|UnitEnum|null $navigationGroup = 'Pages';

    protected static ?int $navigationSort  = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedViewColumns;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::ViewColumns;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return PageLayoutForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PageLayoutsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPageLayouts::route('/'),
            'create' => CreatePageLayout::route('/create'),
            'edit' => EditPageLayout::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
