<?php

namespace App\Filament\Resources\GeneralSettings\Forms\Components\SiteSections;

use App\Traits\Filament\Form\HasHelperLink;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class SiteSection extends Section
{
    use HasHelperLink;

    public static function get(?string $label = 'Website'): static
    {
        return parent::make($label)
            ->columns(['lg' => 2])
            ->columnSpanFull()
            ->statePath('site')
            ->schema([
                TextInput::make('url')
                    ->label('Base URL')
                    ->url()
                    ->readOnly()
                    ->placeholder('https://exryze.com')
                    ->formatStateUsing(fn() => config('app.url'))
                    ->helperText(app(self::class)->helperLink('APP_URL', 'environment')),
                TextInput::make('dashboard_url')
                    ->label('Dashboard URL')
                    ->prefix(config('app.url').'/')
                    ->minLength('5')
                    ->nullable(false),
                TextInput::make('name')
                    ->label('Website Name')
                    ->columnSpanFull()
                    ->readOnly()
                    ->dehydrated(true)
                    ->placeholder('Ex-CMS')
                    ->formatStateUsing(fn () => config('app.name'))
                    ->helperText(app(self::class)->helperLink('APP_NAME', 'environment')),
                Textarea::make('description')
                    ->label('Website Description')
                    ->columnSpanFull(),
                FileUpload::make('favicon')
                    ->label('Website Favicon')
                    ->columnSpan(['md' => 1])
                    ->image()
                    ->disk('public')
                    ->directory('assets')
                    ->imageEditor()
                    ->getUploadedFileNameForStorageUsing(fn () => 'favicon.ico')
                    ->acceptedFileTypes(['image/x-icon', 'image/vnd.microsoft.icon']),
                FileUpload::make('logo')
                    ->label('Website Logo')
                    ->columnSpan(['md' => 1])
                    ->image()
                    ->disk('public')
                    ->directory('assets')
                    ->imageEditor()
                    ->getUploadedFileNameForStorageUsing(fn () => 'logo.png')
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp']),
            ]);
    }
}