<?php

namespace App\Filament\Pages;

use App\Filament\Actions\OptimizeAction;
use App\Filament\Resources\GeneralSettings\Schemas\GeneralSettingsForm;
use App\Mail\TestMail;
use App\Models\GeneralSetting;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use UnitEnum;

class GeneralSettingsPage extends Page
{
    use HasPageShield;

    protected string $view = 'filament.pages.general-settings-page';

    protected static ?string $slug = 'general-settings';

    protected static ?string $title = 'General Settings';

    protected static ?string $navigationLabel = 'General Settings';

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort  = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::WrenchScrewdriver;

    public ?array $setting = [];

    public function mount(): void
    {
        $this->setting = GeneralSetting::first()?->toArray() ?: [];

        if ($this->setting['theme']) {
            foreach ($this->setting['theme'] as $key => $value) {
                $this->setting['theme'][$key] = $value ? 'rgb('.$value[500].')' : null;
            }
        }
        // dd($this->setting);

        $this->form->fill($this->setting);
    }

    public function form(Schema $schema): Schema
    {
        return GeneralSettingsForm::configure($schema);
    }

    protected function getHeaderActions(): array
    {
        return [
            OptimizeAction::make('optimize')
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('update')
                ->label('Update')
                ->submit('update')
                ->color('primary'),
        ];
    }

    public function update(): void
    {
        $setting = $this->form->getState();
        // dd($setting);
        unset($setting['mail_to']);

        foreach ($setting['theme'] as $key => $value) {
            $setting['theme'][$key] = $value ? Color::rgb($value) : null;
        }

        // if ($setting['navigation']['nav_items']) {
        //     foreach ($setting['navigation']['nav_items'] as $key => $value) {
        //         if ($value['type'] == 'link') {
        //             $setting['navigation']['nav_items'][$key]['page'] = null;
        //         } else {
        //             $setting['navigation']['nav_items'][$key]['link'] = null;
        //         }
        //     }
        // }

        GeneralSetting::updateOrCreate(['id' => 1], $setting);

        $this->successNotification('Settings updated');
        redirect(request()?->header('Referer'));
    }

    public function sendTestMail(): void
    {
        $setting = $this->form->getState();
        $email = $setting['email_settings']['mail_to'];

        try {
            Mail::to($email)
                ->send(new TestMail([
                    'subject' => 'This is a test email to verify SMTP settings',
                    'body' => 'This is for testing email using smtp.',
                ]));
        } catch (\Exception $e) {
            $this->errorNotification('Email test error', $e->getMessage());

            return;
        }

        $this->successNotification('Email test success' . $email);
    }

    private function successNotification(string $title): void
    {
        Notification::make()
            ->title($title)
            ->success()
            ->send();
    }

    private function errorNotification(string $title, string $body): void
    {
        Log::error('[EMAIL] ' . $body);

        Notification::make()
            ->title($title)
            ->danger()
            ->body($body)
            ->send();
    }
}
