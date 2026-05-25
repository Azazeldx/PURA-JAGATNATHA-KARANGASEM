<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $table = 'general_settings';

    protected $fillable = [
        'site',
        'location',
        'contacts',
        'theme',
        'email_settings',
        'social_network',
        'navigation',
        'features',
    ];

    protected $casts = [
        'site' => 'array',
        'location' => 'array',
        'contacts' => 'array',
        'theme' => 'array',
        'email_settings' => 'array',
        'social_network' => 'array',
        'navigation' => 'array',
        'features' => 'array',
    ];

    protected static function booted()
    {
        static::saving(function ($setting) {
            // dd($setting);
        });
    }

}
