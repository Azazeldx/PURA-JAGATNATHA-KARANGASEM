<?php

namespace App\Filament\Resources\GeneralSettings\Schemas\Components\SettingTabs;

use App\Enums\GeneralSettingsEnums\EmailProviderEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;

class EmailTab extends Tab
{
    public static function get(?string $label = 'Email'): static
    {
        return parent::make($label)
            ->icon(Heroicon::OutlinedEnvelope)
            ->visible(fn ($get) => $get('features.global.mail.enable'))
            ->schema([
                Grid::make()
                    ->columns(['lg' => 3])
                    ->columnSpanFull()
                    ->statePath('email_settings')
                    ->schema([
                        Grid::make()
                            ->columns(['lg' => 2])
                            ->columnSpan(['lg' => 2])
                            ->schema([
                                Section::make()
                                    ->columns(1)
                                    ->columnSpanFull()
                                    ->schema([
                                        Select::make('default_email_provider')
                                            ->native(false)
                                            ->allowHtml()
                                            ->preload()
                                            ->options(function () {
                                                $options = [];
                                                foreach (EmailProviderEnum::options() as $key => $value) {
                                                    if (file_exists(public_path('image/filament/email-providers/' . strtolower($value) . '.svg'))) {
                                                        $options[strtolower($value)] = '<div class="flex gap-2">' .
                                                            ' <img src="' . asset('image/filament/email-providers/' . strtolower($value) . '.svg') . '"  class="h-5">'
                                                            . $value
                                                            . '</div>';
                                                    } else {
                                                        $options[strtolower($value)] = $value;
                                                    }
                                                }
                
                                                return $options;
                                            })
                                            ->helperText('This is the email provider that will be used for all emails.')
                                            ->live()
                                            ->columnSpanFull(),
                                        Group::make()
                                            ->schema([
                                                TextInput::make('smtp_host')
                                                    ->label('Host'),
                                                TextInput::make('smtp_port')
                                                    ->label('Port'),
                                                Select::make('smtp_encryption')
                                                    ->label('Encryption')
                                                    ->options([
                                                        'ssl' => 'SSL',
                                                        'tls' => 'TLS',
                                                    ]),
                                                TextInput::make('smtp_timeout')
                                                    ->label('Timeout'),
                                                TextInput::make('smtp_username')
                                                    ->label('Username'),
                                                TextInput::make('smtp_password')
                                                    ->label('Password'),
                                            ])
                                            ->columns(2)
                                            ->visible(fn ($state) => $state['default_email_provider'] === 'smtp'),
                                        Group::make()
                                            ->schema([
                                                TextInput::make('mailgun_domain'),
                                                TextInput::make('mailgun_secret'),
                                                TextInput::make('mailgun_endpoint'),
                                            ])
                                            ->columns(1)
                                            ->visible(fn ($state) => $state['default_email_provider'] === 'mailgun'),
                                        Group::make()
                                            ->schema([
                                                TextInput::make('postmark_token'),
                                            ])
                                            ->columns(1)
                                            ->visible(fn ($state) => $state['default_email_provider'] === 'postmark'),
                                        Group::make()
                                            ->schema([
                                                TextInput::make('amazon_ses_key'),
                                                TextInput::make('amazon_ses_secret'),
                                                TextInput::make('amazon_ses_region')
                                                    ->default('us-east-1'),
                                            ])
                                            ->columns(1)
                                            ->visible(fn ($state) => $state['default_email_provider'] === 'ses'),
                                    ]),
                            ]),
                        Grid::make()
                            ->columns(1)
                            ->columnSpan(['lg' => 1])
                            ->schema([
                                Section::make([
                                    TextInput::make('email_from_name')
                                        ->helperText('This is the name that will be used as the "From" name for all emails.'),
                                    TextInput::make('email_from_address')
                                        ->helperText('This is the email address that will be used as the "From" email address for all emails.')
                                        ->email(),
                                ]),
                                Section::make()
                                    ->schema([
                                        TextInput::make('mail_to')
                                            ->hiddenLabel()
                                            ->placeholder('Receiver email address')
                                            ->reactive(),
                                        Actions::make([
                                            Action::make('Send Test Mail')
                                                ->disabled(fn ($state) => empty($state['mail_to']))
                                                ->action('sendTestMail')
                                                ->color('warning')
                                                ->icon('heroicon-o-paper-airplane'),
                                        ])->fullWidth(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
