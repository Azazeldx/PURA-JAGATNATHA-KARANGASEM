<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Models\Post;
use App\Models\PostType;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        $user = auth()->user();

        if (!$user->can('ViewPublic:Post')) {
            $post = Post::where('author_id', $user->id)->count();
        } else {
            $post = Post::count();
        }

        $tabs['all'] = Tab::make('all')
            ->label('All Posts')
            ->badge($post);

        foreach (PostType::all() as $type) {
            if (!$user->can('ViewPublic:Post')) {
                $post = Post::where('post_type_id', $type->id)->where('author_id', $user->id)->count();
            } else {
                $post = Post::where('post_type_id', $type->id)->count();
            }

            if ($post == 0) continue;

            $tabs[$type->slug] = Tab::make($type->slug)
                ->label($type->title)
                ->modifyQueryUsing(fn (Builder $query) =>
                    $query->where('post_type_id', $type->id)
                )
                ->badge($post);
        }

        return $tabs;
    }
}
