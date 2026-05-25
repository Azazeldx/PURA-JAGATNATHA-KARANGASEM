<?php

namespace App\Contracts;

interface FeatureConfig
{
    public function get(string $key, $default = null);
    
    public function enabled(string $key, $default = false): bool;

    public function schema(string $key, $default = []): array;
}
