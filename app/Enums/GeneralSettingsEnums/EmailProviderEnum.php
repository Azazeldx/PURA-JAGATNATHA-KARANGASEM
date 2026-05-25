<?php

namespace App\Enums\GeneralSettingsEnums;

use App\Traits\WithOptions;

enum EmailProviderEnum: string
{
    use WithOptions;

    case SMTP = 'SMTP';
    // case MAILGUN = 'Mailgun';
    // case SES = 'Amazon SES';
    // case POSTMARK = 'Postmark';
}
