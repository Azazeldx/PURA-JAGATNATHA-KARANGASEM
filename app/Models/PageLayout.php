<?php

namespace App\Models;

use App\Enums\PageEnums\PageRegionEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageLayout extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'layout_schema',
    ];

    protected $casts = [
        'layout_schema' => 'array',
    ];

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function layoutSorted()
    {
        return collect(PageRegionEnum::options())
            ->mapWithKeys(fn ($value, $key) => [
            $key => $this->layout_schema['enable'][$key] ?? false
            ])
            ->toArray();
    }
}
