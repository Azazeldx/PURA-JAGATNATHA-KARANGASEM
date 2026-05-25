<?php

namespace App\Traits\Filament\Form;

use App\Services\GeneralSettingsService;
use Illuminate\Support\HtmlString;

trait HasHelperLink
{
    protected function helperLink(string $label, string $url): HtmlString
    {
        return new HtmlString(
            sprintf(
                'Ref: <a href="%s" target="_blank" class="fi-color fi-color-primary fi-text-color-700 dark:fi-text-color-400">%s</a>',
                e(url(app(GeneralSettingsService::class)->get('site.dashboard_url').'/'.$url)),
                e($label),
            )
        );
    }
}
