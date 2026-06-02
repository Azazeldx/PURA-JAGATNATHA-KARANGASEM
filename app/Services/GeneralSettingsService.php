<?php

namespace App\Services;

use App\Contracts\GeneralSettingsConfig;
use App\Models\GeneralSetting;
use App\Models\Page;

class GeneralSettingsService implements GeneralSettingsConfig
{
    protected string $configKey = 'exryze.general_settings';

    protected array $settings;

    public function __construct()
    {
        $this->settings = $this->resolveSettings();
    }

    public function all(): array
    {
        return $this->settings;
    }

    public function get(string $key, $default = null)
    {
        return data_get($this->settings, $key, $default);
    }

    protected function resolveSettings(): array
    {
        $settings = config($this->configKey, []);
        $generalSetting = GeneralSetting::first();

        if (!$generalSetting) {
            return $settings;
        }

        $data = collect($generalSetting->toArray())
            ->except(['id', 'created_at', 'updated_at'])
            ->filter(fn ($value) => $value !== null)
            ->toArray();

        $settings = array_replace_recursive($settings, $data);

        if (!empty($data['navigation']) && is_array($data['navigation'])) {
            $settings['navigation'] = $this->resolveNavigation($data['navigation']);
        }

        return $settings;
    }

    protected function resolveNavigation(array $navigation): array
    {
        $navigation['nav_items'] ??= [];

        if (!empty($navigation['home']) && is_array($navigation['home'])) {
            $navigation['home']['page'] = $this->resolvePage($navigation['home']['page_id'] ?? null);
        }

        if (!empty($navigation['search']) && is_array($navigation['search'])) {
            $navigation['search']['page'] = $this->resolvePage($navigation['search']['page_id'] ?? null);
        }

        foreach ($navigation['nav_items'] as $key => $value) {
            if (($value['type'] ?? null) === 'page') {
                $navigation['nav_items'][$key]['page'] = $this->resolvePage($value['page_id'] ?? null);
            }
        }

        return $navigation;
    }

    protected function resolvePage($pageId): ?array
    {
        if (!$pageId) {
            return null;
        }

        return Page::query()
            ->whereKey($pageId)
            ->first(['title', 'slug'])
            ?->toArray();
    }
}