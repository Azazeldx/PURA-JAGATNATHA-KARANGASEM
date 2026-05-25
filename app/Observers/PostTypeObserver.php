<?php

namespace App\Observers;

use App\Models\PostType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;

class PostTypeObserver
{
    /**
     * Membangun nama permission sesuai konvensi Shield di config
     */
    protected function getPermissionName(string $action, string $slug): string
    {
        $case = config('filament-shield.permissions.case', 'snake');
        $separator = config('filament-shield.permissions.separator', '_');
        
        // Format dasar: {action}_{slug}_post
        // Contoh: view_any_news_post
        $permission = "{$action}{$separator}{$slug}{$separator}post";

        return match ($case) {
            'pascal' => Str::ucfirst(Str::camel($permission)),
            'kebab'  => Str::kebab($permission),
            'camel'  => Str::camel($permission),
            'snake'  => Str::snake($permission),
            default  => $permission,
        };
    }

    public function created(PostType $postType): void
    {
        // Ambil list methods/actions langsung dari config shield
        $actions = config('filament-shield.policies.methods', [
            'viewAny', 'view', 'create', 'update', 'delete', 'restore', 'forceDelete'
        ]);

        foreach ($actions as $action) {
            // Kita konversi action ke snake_case untuk konsistensi nama permission
            // misal 'viewAny' menjadi 'view_any'
            $formattedAction = Str::snake($action);
            
            Permission::firstOrCreate([
                'name' => $this->getPermissionName($formattedAction, $postType->slug),
                'guard_name' => 'web'
            ]);
        }
        
        $this->clearCache();
    }

    public function updated(PostType $postType): void
    {
        if ($postType->isDirty('slug')) {
            $oldSlug = $postType->getOriginal('slug');
            $actions = config('filament-shield.policies.methods');

            foreach ($actions as $action) {
                $formattedAction = Str::snake($action);
                $oldName = $this->getPermissionName($formattedAction, $oldSlug);
                $newName = $this->getPermissionName($formattedAction, $postType->slug);

                $permission = Permission::where('name', $oldName)->first();
                if ($permission) {
                    $permission->update(['name' => $newName]);
                }
            }
        }
        
        $this->clearCache();
    }

    public function deleted(PostType $postType): void
    {
        $actions = config('filament-shield.policies.methods');
        
        foreach ($actions as $action) {
            $formattedAction = Str::snake($action);
            Permission::where('name', $this->getPermissionName($formattedAction, $postType->slug))->delete();
        }
        
        $this->clearCache();
    }

    protected function clearCache(): void
    {
        Cache::forget('all_post_types_slugs');
        // Jika Anda menggunakan cache per user di getEloquentQuery, 
        // Anda mungkin perlu membersihkan cache secara global atau menggunakan tags.
        // Cache::tags(['post_permissions'])->flush(); 
    }
}