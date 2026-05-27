<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;

class VisionMissionSectionSeeder extends Seeder
{
    public function run()
    {
        $schema = [
            'type' => 'dynamic',
            'view_path' => 'dynamic.main.vision-mission',
            'schema' => [
                [ 'type' => 'heading', 'data' => [ 'key' => 'title' ] ],
                [ 'type' => 'paragraph', 'data' => [ 'key' => 'subtitle' ] ],
                [ 'type' => 'heading', 'data' => [ 'key' => 'vision_title' ] ],
                [ 'type' => 'paragraph', 'data' => [ 'key' => 'vision_text' ] ],
                [ 'type' => 'paragraph', 'data' => [ 'key' => 'missions_0' ] ],
                [ 'type' => 'paragraph', 'data' => [ 'key' => 'missions_1' ] ],
                [ 'type' => 'paragraph', 'data' => [ 'key' => 'missions_2' ] ],
            ],
        ];

        // Try to find existing section by known slugs or titles (case variations).
        $existing = PageSection::where('slug', 'vision-mission')
            ->orWhere('slug', 'visi-misi')
            ->orWhere('title', 'Visi & Misi')
            ->orWhere('title', 'Visi & misi')
            ->first();

        if ($existing) {
            // Update existing record to use the new dynamic view/schema
            $existing->update([
                'section_schema' => $schema,
            ]);

            return;
        }

        $schema = [
            'type' => 'dynamic',
            'view_path' => 'dynamic.main.vision-mission',
            'schema' => [
                [ 'type' => 'heading', 'data' => [ 'key' => 'title' ] ],
                [ 'type' => 'paragraph', 'data' => [ 'key' => 'subtitle' ] ],
                [ 'type' => 'heading', 'data' => [ 'key' => 'vision_title' ] ],
                [ 'type' => 'paragraph', 'data' => [ 'key' => 'vision_text' ] ],
                [ 'type' => 'paragraph', 'data' => [ 'key' => 'missions_0' ] ],
                [ 'type' => 'paragraph', 'data' => [ 'key' => 'missions_1' ] ],
                [ 'type' => 'paragraph', 'data' => [ 'key' => 'missions_2' ] ],
            ],
        ];

        PageSection::create([
            'title' => 'Visi & Misi',
            'slug' => 'vision-mission',
            'region' => 'main',
            'section_schema' => $schema,
        ]);
    }
}
