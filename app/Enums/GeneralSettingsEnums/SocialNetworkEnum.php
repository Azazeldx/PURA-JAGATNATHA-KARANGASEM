<?php

namespace App\Enums\GeneralSettingsEnums;

use App\Traits\WithOptions;

enum SocialNetworkEnum: string
{
    use WithOptions;

    // Make sure the name of item as same as the icon brand in font awsome
    case Whatsapp = 'whatsapp';
    case Facebook = 'facebook';
    case Instagram = 'instagram';
    case Twitter = 'x_twitter';
    case Youtube = 'youtube';
    case Linkedin = 'linkedin';
    case Tiktok = 'tiktok';
    case Pinterest = 'pinterest';
}
