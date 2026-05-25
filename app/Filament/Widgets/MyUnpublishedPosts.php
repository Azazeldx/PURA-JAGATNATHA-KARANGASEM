<?php

namespace App\Filament\Widgets;

use App\Enums\PostEnums\PostStatusEnum;
use App\Filament\Resources\Posts\Tables\PostsTable;
use App\Models\Post;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class MyUnpublishedPosts
 extends TableWidget
{
    use HasWidgetShield;

    protected static ?string $heading = 'My Unpublished Posts';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $table = PostsTable::configure($table);
        return $table
            ->query(fn (): Builder =>
                Post::query()
                    ->where('author_id', auth()->id())
                    ->where('status', PostStatusEnum::Draft->value)
                    ->orderByDesc('created_at')
            );
    }
}
