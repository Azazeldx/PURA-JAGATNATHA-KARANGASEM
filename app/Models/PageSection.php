<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageSection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'region',
        'section_schema',
    ];

    protected $casts = [
        'section_schema' => 'array',
    ];
}
