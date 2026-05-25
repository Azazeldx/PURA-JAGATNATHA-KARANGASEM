<?php

namespace App\Providers;

use App\Policies\MediaPolicy;
use App\Services\FeatureService;
use App\Services\GeneralSettingsService;
use Awcodes\Curator\Models\Media;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Media::class, MediaPolicy::class);
        // PostType::observe(\App\Observers\PostTypeObserver::class);

        // View::addNamespace('exryze', resource_path('views/exryze/components'));
        View::share('settings', app(GeneralSettingsService::class));
        View::share('features', app(FeatureService::class));

        Blade::anonymousComponentPath(
            resource_path('views/exryze/components'),
            'exryze'
        );
    }
}
