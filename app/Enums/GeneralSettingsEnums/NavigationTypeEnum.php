<?php

namespace App\Enums\GeneralSettingsEnums;

use App\Traits\WithOptions;

enum NavigationTypeEnum: string
{
    use WithOptions;

    case Page = 'page';
    case Link = 'link';
}
