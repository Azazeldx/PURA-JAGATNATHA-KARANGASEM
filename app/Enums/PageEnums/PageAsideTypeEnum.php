<?php

namespace App\Enums\PageEnums;

use App\Traits\WithOptions;

enum PageAsideTypeEnum: string
{
    use WithOptions;

    case Right = 'right';
    case Left = 'left';
    case Both = 'both';
}
