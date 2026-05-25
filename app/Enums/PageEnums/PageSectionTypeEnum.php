<?php

namespace App\Enums\PageEnums;

use App\Traits\WithOptions;

enum PageSectionTypeEnum: string
{
    use WithOptions;

    case Static = 'static';
    case Dynamic = 'dynamic';
    case Builder = 'builder';
}
