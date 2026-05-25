<?php

namespace App\Filament\Actions;

use Filament\Actions\Action;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class OptimizeAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'optimize';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->outlined()
            ->label('Optimize')
            ->tooltip('Sync general settings & run php artisan optimize')
            ->action(function () {

                // Sync general settings (Ref:app/command)
                Artisan::call('settings:sync');
                $syncOutput = Artisan::output();

                // Optimize
                Artisan::call('optimize');
                $optimizeOutput = Artisan::output();

                // Cleaning
                $output = trim(
                    "== Settings Sync ==\n"
                    . $syncOutput
                    . "\n\n== Optimize ==\n"
                    . $optimizeOutput
                );

                $output = Str::replace(
                    str_repeat('.', 50),
                    '...',
                    $output
                );

                // Show notification
                $this->successNotificationTitle(
                    new HtmlString('<pre style="text-align:left">' . e($output) . '</pre>')
                );

                $this->success();
            });
        
        // After finish go to the dashboard page
    }
}
