<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'page_content',
        'metadata',
        'post_layout_id',
        'published_at'
    ];

    protected $casts = [
        'page_content' => 'array',
        'metadata' => 'array',
    ];

    public function layout(): BelongsTo
    {
        return $this->belongsTo(PageLayout::class, 'page_layout_id', 'id');
    }
}
