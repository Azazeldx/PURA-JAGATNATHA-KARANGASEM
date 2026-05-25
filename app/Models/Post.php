<?php

namespace App\Models;

use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'cover_id',
        'slug',
        'status',
        'description',
        'content',
        'card_content',
        'page_content',
        'post_type_id',
        'author_id',
        'published_at',
        'highlighted_at',
    ];

    protected $casts = [
        'content' => 'array',
        'card_content' => 'array',
        'page_content' => 'array',
        'published_at' => 'datetime',
        'highlighted_at' => 'datetime',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(PostType::class, 'post_type_id', 'id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function cover(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'cover_id', 'id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(PostCategory::class, 'post_category_post');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(PostTag::class, 'post_tag_post');
    }
}
