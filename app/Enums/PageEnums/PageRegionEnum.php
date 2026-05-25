<?php

namespace App\Enums\PageEnums;

use App\Traits\WithOptions;

enum PageRegionEnum: string
{
    use WithOptions;

    case Navigation = 'navigation';
    case Header = 'header';
    case Main = 'main';
    case Aside = 'aside';
    case Footer = 'footer';
}
