<?php

namespace App\Support;

use App\Models\Page;
use App\Models\Post;
use App\Services\GeneralSettingsService;

class Metadata
{
    public static function normalize(Page $page, Post|null $post = null): Page
    {
        $site = app(GeneralSettingsService::class)->get('site');
        $meta = $page->metadata;

        $data = [
            'title' => $page->title . ' - ' . $site['name'],
        ];

        if ($post) {
            $data = [
                'title' => $post->title . ' - ' . $site['name'],
                'description' => $post->description,
                'image' => $post->cover->path,
            ];
        }

        $default = [
            'title' => $data['title'] ?? $site['name'],
            'description' => $data['description'] ?? $site['description'],
            'keywords' => [],
            'canonical' => url()->current(),
            'favicon' => $site['favicon'] ?? null,
            'image' => $data['image'] ?? $site['logo'] ?? asset('placeholder.svg'),
        ];

        $basic = $meta['basic'] ?? [];
        $og = $meta['open_graph'] ?? [];
        $twitter = $meta['twitter'] ?? [];
        $robots = $meta['robots'] ?? [];

        $page->metadata = [
            'favicon' => $default['favicon'],
            'title' => $basic['title'] ?? $default['title'],
            'description' => $basic['description'] ?? $default['description'],
            'keywords' => $basic['keywords'] ?? [],
            'canonical' => $basic['canonical'] ?? $default['canonical'],

            'robots' => [
                'index' => $robots['index'] ?? true,
                'follow' => $robots['follow'] ?? true,
            ],

            'og' => [
                'title' => $og['title'] ?? $basic['title'] ?? $default['title'],
                'description' => $og['description'] ?? $basic['description'] ?? $default['description'],
                'type' => $og['type'] ?? 'website',
                'image' => $og['image'] ?? $default['image'],
            ],

            'twitter' => [
                'title' => $twitter['title'] ?? $basic['title'] ?? $default['title'],
                'description' => $twitter['description'] ?? $basic['description'] ?? $default['description'],
                'card' => $twitter['card'] ?? 'summary_large_image',
                'image' => $twitter['image'] ?? $og['image'] ?? $default['image'],
            ],
        ];

        return $page;
    }
}