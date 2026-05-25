<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Enums\PostEnums\PostStatusEnum;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Zvizvi\UserFields\Components\UserColumn;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                CuratorColumn::make('cover_id')
                    ->label('Cover')
                    ->imageSize(40),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('type.title')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        PostStatusEnum::Draft->value => 'gray',
                        PostStatusEnum::Published->value => 'success',
                        default => 'gray',
                    }),
                // IconColumn::make('highlighted_at')
                //     ->label('Highlight')
                //     ->icon(Heroicon::Star)
                //     ->color(fn ($record): string => $record->highlighted_at ? 'warning' : 'gray')
                //     ->action(function ($record): void {
                //         $record->update([
                //             'highlighted_at' => $record->highlighted_at ? null : now(),
                //         ]);
                //     })
                //     ->sortable()
                //     ->toggleable(),
                UserColumn::make('author')
                    ->label('Author'),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('toggle_publish')
                        ->visible(fn () => auth()->user()->can('Publish:Post'))
                        ->label(fn ($record): string => $record->status === PostStatusEnum::Published->value ? 'Unpublish' : 'Publish')
                        ->icon(fn ($record) => $record->status === PostStatusEnum::Published->value ? Heroicon::EyeSlash : Heroicon::Eye)
                        ->color(fn ($record): string => $record->status === PostStatusEnum::Published->value ? 'gray' : 'success')
                        ->action(function ($record): void {
                            $newStatus = $record->status === PostStatusEnum::Published->value
                                ? PostStatusEnum::Draft->value
                                : PostStatusEnum::Published->value;

                            $record->update([
                                'status' => $newStatus,
                                'published_at' => $newStatus === PostStatusEnum::Published->value ? now() : null,
                            ]);
                        }),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
