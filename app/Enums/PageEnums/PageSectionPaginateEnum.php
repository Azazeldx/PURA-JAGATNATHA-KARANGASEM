<?php

namespace App\Enums\PageEnums;

use App\Traits\WithOptions;

enum PageSectionPaginateEnum: string
{
    use WithOptions;

    case None = 'none';
    case Simple = 'simple';
    case Paginate = 'paginate';
}
