<?php

namespace App\Services;

use App\Contracts\FeatureConfig;

class FeatureService implements FeatureConfig
{
    public function __construct(
        protected GeneralSettingsService $settings
    ) {}

    protected function basePath(): string
    {
        return 'features';
    }

    public function get(string $key, $default = null)
    {
        return (bool) $this->settings->get(
            $this->basePath().'.'.$key,
            $default
        );
    }

    public function enabled(string $key, $default = false): bool
    {
        return (bool) $this->settings->get(
            $this->basePath().'.'.$key.'.enable',
            $default
        );
    }

    public function schema(string $key, $default = []): array
    {
        $result = $this->settings->get(
            $this->basePath().'.'.$key,
            $default
        );

        if (!is_array($result)) {
            return $default;
        }

        unset($result['enable']);

        return $result;
    }
}