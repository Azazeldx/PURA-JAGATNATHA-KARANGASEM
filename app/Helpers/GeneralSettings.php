<?php

use App\Services\FeatureService;
use App\Services\GeneralSettingsService;

function generalSettingGet(string $key)
{
    return app(GeneralSettingsService::class)->get($key);
}

function featureGet(string $key)
{
    return app(FeatureService::class)->get($key);
}

function featureEnable(string $key): bool
{
    return app(FeatureService::class)->enabled($key);
}

function featureSchema(string $key): array
{
    return app(FeatureService::class)->schema($key);
}