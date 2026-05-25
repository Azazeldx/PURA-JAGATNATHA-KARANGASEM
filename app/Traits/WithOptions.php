<?php

namespace App\Traits;

trait WithOptions
{
    public static function options(?array $cases = null): array
    {
        $cases ??= static::cases();

        return collect($cases)
            ->mapWithKeys(fn ($item) => [
                $item->value => __($item->name)
            ])
            ->toArray();
    }
}
