<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InitialSeeder extends Seeder
{
    public function run(): void
    {
        $path = config_path('exryze/general_settings');

        if (!File::exists($path)) {
            $this->command->warn('Setting directory not found.');
            return;
        }

        DB::table('general_settings')->truncate();

        $payload = [];

        foreach (File::files($path) as $file) {
            $key = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $value = require $file->getPathname();

            $payload[$key] = $this->reverseTransform($key, $value);
        }

        DB::table('general_settings')->insert([
            ...$payload,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function reverseTransform(string $key, $value)
    {
        if ($key === 'navigation' && is_array($value)) {

            if (!empty($value['home']['id'])) {
                $value['home'] = $value['home']['id'];
            }

            if (!empty($value['search']['id'])) {
                $value['search'] = $value['search']['id'];
            }

            if (!empty($value['nav_items'])) {
                foreach ($value['nav_items'] as $i => $item) {
                    if (($item['type'] ?? null) === 'page'
                        && isset($item['page']['id'])) {

                        $value['nav_items'][$i]['page'] =
                            $item['page']['id'];
                    }
                }
            }
        }

        if ($key === 'theme' && is_array($value)) {
            if (!empty($data['theme']) && is_array($data['theme'])) {
                foreach ($data['theme'] as $colorKey => $color) {
                    if (is_array($color)) {
                        foreach ($color as $shadeKey => $shade) {
                            $data['theme'][$colorKey][$shadeKey] =
                                is_string($shade) ? str_replace(' ', ', ', $shade) : $shade;
                        }
                    }
                }
            }
        }

        return is_array($value)
            ? json_encode($value)
            : $value;
    }
}
