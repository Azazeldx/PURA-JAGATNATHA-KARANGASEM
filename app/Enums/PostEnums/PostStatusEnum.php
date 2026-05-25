<?php

namespace App\Enums\PostEnums;

use App\Traits\WithOptions;

enum PostStatusEnum: string
{
    use WithOptions;

    case Draft = 'draft';
    case Published = 'published';
    // case Archived = 'archived';
}
