<?php

namespace App\Contracts;

interface GeneralSettingsConfig
{
    public function all(): array;

    public function get(string $key, $default = null);
}
