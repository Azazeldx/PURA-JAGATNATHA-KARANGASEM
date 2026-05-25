<?php

namespace App\Services;

use App\Contracts\GeneralSettingsConfig;

class GeneralSettingsService implements GeneralSettingsConfig
{
    protected string $configKey = 'exryze.general_settings';

    protected array $settings;

    public function __construct()
    {
        $this->settings = config($this->configKey, []);
    }

    public function all(): array
    {
        return $this->settings;
    }

    public function get(string $key, $default = null)
    {
        return data_get($this->settings, $key, $default);
    }
}