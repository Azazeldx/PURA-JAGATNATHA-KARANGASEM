<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostType extends Model
{
    protected $table = 'post_types';

    protected $fillable = [
        'title',
        'slug',
        'card_schema',
        'page_schema',
    ];

    protected $casts = [
        'card_schema' => 'array',
        'page_schema' => 'array',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    
    public static function getShieldPermissionName(string $action, string $slug): string
    {
        $case = config('filament-shield.permissions.case', 'snake');
        $separator = config('filament-shield.permissions.separator', '_');
        
        $permission = "{$action}{$separator}{$slug}{$separator}post";

        return match ($case) {
            'pascal' => \Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::camel($permission)),
            'kebab'  => \Illuminate\Support\Str::kebab($permission),
            'camel'  => \Illuminate\Support\Str::camel($permission),
            'snake'  => \Illuminate\Support\Str::snake($permission),
            default  => $permission,
        };
    }
}
