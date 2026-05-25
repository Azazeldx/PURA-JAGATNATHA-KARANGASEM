<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class SyncGeneralSettings extends Command
{
    protected $signature = 'settings:sync';
    protected $description = 'Sync general settings from database to separated config files';

    public function handle()
    {
        if (!Schema::hasTable('general_settings')) {
            $this->warn('General settings table not found.');
            return Command::SUCCESS;
        }

        $settings = DB::table('general_settings')->first();

        if (!$settings) {
            $this->warn('No general settings data found.');
            return Command::SUCCESS;
        }

        $data = collect((array) $settings)
            ->except(['id', 'created_at', 'updated_at'])
            ->map(fn ($value) => $this->decodeIfJson($value))
            ->toArray();

        // Transform navigation relations
        if (!empty($data['navigation'])) {

            $navigation = $data['navigation'];

            $navigation['nav_items'] ??= [];

            $navigation['home']['page'] =
                $this->getData('pages', $navigation['home']['page_id'] ?? null, ['title', 'slug']);

            $navigation['search']['page'] =
                $this->getData('pages', $navigation['search']['page_id'] ?? null, ['title', 'slug']);

            foreach ($navigation['nav_items'] as $key => $value) {
                if (($value['type'] ?? null) === 'page') {
                    $navigation['nav_items'][$key]['page'] =
                        $this->getData('pages', $value['page_id'] ?? null, ['title', 'slug']);
                }
            }

            $data['navigation'] = $navigation;
            
        }

        // Transform theme color cleanup
        if (!empty($data['theme']) && is_array($data['theme'])) {
            foreach ($data['theme'] as $colorKey => $color) {
                if (is_array($color)) {
                    foreach ($color as $shadeKey => $shade) {
                        $data['theme'][$colorKey][$shadeKey] =
                            is_string($shade) ? str_replace(',', '', $shade) : $shade;
                    }
                }
            }
        }

        // Ensure directory exists
        $directory = config_path('exryze/general_settings');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Export each key to its own file
        foreach ($data as $fileName => $content) {
            File::put(
                $directory . '/' . $fileName . '.php',
                "<?php\n\nreturn " . var_export($content ?? [], true) . ";\n"
            );
        }

        $this->info('General settings synced into separated config files.');
        return Command::SUCCESS;
    }

    private function getData(string $table, $id, array $columns)
    {
        if (!$id) return null;

        $result = DB::table($table)
            ->where('id', $id)
            ->first($columns);

        return $result ? (array) $result : null;
    }

    private function decodeIfJson($value)
    {
        if (!is_string($value)) return $value;

        $decoded = json_decode($value, true);

        return json_last_error() === JSON_ERROR_NONE
            ? $decoded
            : $value;
    }
}
