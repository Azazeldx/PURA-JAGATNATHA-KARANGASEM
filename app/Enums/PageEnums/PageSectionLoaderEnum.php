<?php

namespace App\Enums\PageEnums;

use App\Traits\WithOptions;

enum PageSectionLoaderEnum: string
{
    use WithOptions;

    case None = 'none';
    case Defined = 'defined';
    case Url = 'url';
    case Post = 'post';
    case Post_Author = 'post-author';
}
