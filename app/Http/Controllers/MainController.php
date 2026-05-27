<?php

namespace App\Http\Controllers;

use App\Enums\PageEnums\PageAsideTypeEnum;
use App\Enums\PageEnums\PageRegionEnum;
use App\Enums\PageEnums\PageSectionLoaderEnum;
use App\Enums\PageEnums\PageSectionPaginateEnum;
use App\Enums\PageEnums\PageSectionTypeEnum;
use App\Enums\PostEnums\PostStatusEnum;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Post;
use App\Services\GeneralSettingsService;
use App\Support\Metadata;
use Awcodes\Curator\Models\Media;
use Illuminate\Http\Request;

class MainController extends Controller
{
    private function sectionResolver(array $section, array $config, Post|null $post = null) : array {
        switch ($section['type']) {
            case PageSectionTypeEnum::Static->value:
                return $config;
                break;

            case PageSectionTypeEnum::Dynamic->value:
                foreach ($section['schema'] as $block)
                {
                    $key = $block['data']['key'];

                    if ($block['type'] == 'image') {
                        // Safely handle cases where the key may not be present
                        if (array_key_exists($key, $config) && !empty($config[$key])) {
                            $img = Media::where('id', $config[$key])->first();
                            data_set($config, $key, $img);
                        } else {
                            // ensure key exists in config to avoid undefined index errors
                            data_set($config, $key, null);
                        }
                    } else if ($block['type'] == 'posts') {
                        $data = $block['data'];

                        $query = Post::query()
                            ->with(['cover', 'type', 'categories', 'tags', 'author']) // avoid N+1
                            ->when(!empty($data['post_type_id']), function ($q) use ($data) {
                                $q->where('post_type_id', $data['post_type_id']);
                            });

                        switch ($data['reference'] ?? PageSectionLoaderEnum::None->value) {
                            case PageSectionLoaderEnum::Post_Author->value:
                                $query->where('id', '!=', $post->id)
                                    ->where('author_id', $post->author_id);
                                break;

                            case PageSectionLoaderEnum::Post->value:
                                $tagIds = $post->tags->pluck('id')->filter()->values();
                                $categoryIds = $post->categories->pluck('id')->filter()->values();

                                $query->where('id', '!=', $post->id)
                                    ->when($tagIds->isNotEmpty(), function ($q) use ($tagIds) {
                                        $q->whereHas('tags', function ($tagQuery) use ($tagIds) {
                                            $tagQuery->whereIn('post_tags.id', $tagIds);
                                        });
                                    })

                                    ->when($categoryIds->isNotEmpty(), function ($q) use ($categoryIds) {
                                        $q->whereHas('categories', function ($catQuery) use ($categoryIds) {
                                            $catQuery->whereIn('post_categories.id', $categoryIds);
                                        });
                                    });

                                // Sorting rangking
                                $query
                                    ->withCount([
                                        'tags as matched_tags_count' => function ($q) use ($tagIds) {
                                            $q->whereIn('post_tags.id', $tagIds);
                                        },
                                        'categories as matched_categories_count' => function ($q) use ($categoryIds) {
                                            $q->whereIn('post_categories.id', $categoryIds);
                                        }
                                    ])
                                    ->orderByDesc('matched_tags_count')
                                    ->orderByDesc('matched_categories_count');
                                break;

                            default:
                                $query
                                    ->when(!empty($data['post_tags']), function ($q) use ($data) {
                                        $q->whereHas('tags', function ($tagQuery) use ($data) {
                                            $tagQuery->whereIn('post_tags.id', $data['post_tags']);
                                        });
                                    })

                                    ->when(!empty($data['post_categories']), function ($q) use ($data) {
                                        $q->whereHas('categories', function ($catQuery) use ($data) {
                                            $catQuery->whereIn('post_categories.id', $data['post_categories']);
                                        });
                                    })
                            ->where('status', PostStatusEnum::Published->value)
                            ->latest('published_at');
                        }

                        if (empty($data['take'])) $data['take'] = 0;

                        switch ($data['paginate'] ?? PageSectionPaginateEnum::None->value) {
                            case PageSectionPaginateEnum::Simple->value:
                                $data = $query->simplePaginate(
                                    perPage: $data['take'],
                                    pageName: 'page'
                                    );
                                break;

                            case PageSectionPaginateEnum::Paginate->value:
                                $data = $query->paginate(
                                    perPage: $data['take'],
                                    pageName: 'page'
                                    );
                                break;

                            default:
                                $data = $query->take($data['take'])->get();
                                break;
                        }

                        data_set($config, $key, $data);
                    }
                }
                break;

            case PageSectionTypeEnum::Builder->value:
                # code...
                break;

            default:
                # code...
                break;
        }

        if (isset($config['section_id'])) {
            unset($config['section_id']);
        }

        return $config;
    }

    private function layoutResolver(Request $request, Page $page, Post|null $post = null)
    {
        $page =  Metadata::normalize($page, $post);
        $meta = $page->metadata;
        $schema = $page->layout->layoutSorted();
        $regions = [];
        $content = [];

        foreach ($schema as $region => $enable) {
            if (!$enable) continue;

            switch ($region) {
                case PageRegionEnum::Main->value:
                    foreach (data_get($page->page_content, PageRegionEnum::Main->value, []) as $section => $config) {
                        $sectionId = data_get($config, 'section_id');

                        // Skip malformed/incomplete repeater items that do not
                        // have a selected section yet.
                        if (! $sectionId) {
                            continue;
                        }

                        $sectionSchema = PageSection::where('id', $sectionId)->first(['slug', 'section_schema']);

                        if (is_null($sectionSchema)) continue;

                        $regions[$region][$sectionSchema->slug] = $sectionSchema->section_schema;

                        $content[$region][$sectionSchema->slug] = $this->sectionResolver($regions[$region][$sectionSchema->slug], $page->page_content[$region][$section] ?? [], $post);
                        $content[$region][$sectionSchema->slug]['id'] = $sectionSchema->slug;
                    }
                    break;

                case PageRegionEnum::Aside->value:
                    $type = data_get($page->layout->layout_schema, 'enable.aside_type');

                    switch ($type) {
                        case PageAsideTypeEnum::Left->value:
                            $asides = ['aside_left'];
                            break;

                        case PageAsideTypeEnum::Right->value:
                            $asides = ['aside_right'];
                            break;

                        default:
                            $asides = ['aside_left', 'aside_right'];
                            break;
                    }

                    foreach ($asides as $aside) {
                        $regions[$aside] = PageSection::where('id', data_get($page->layout->layout_schema, $aside.'.section_id'))->first(['slug', 'section_schema']);

                        if (is_null($regions[$aside])) continue;

                        $content[$aside] = $this->sectionResolver($regions[$aside]->section_schema, $page->page_content[$aside] ?? [], $post);
                        $content[$aside]['id'] = $regions[$aside]->slug;
                    }
                    break;

                default:
                    if ($region == 'aside_type') break;

                    $regions[$region] = PageSection::where('id', data_get($page->layout->layout_schema, $region.'.section_id'))->first(['slug', 'section_schema']);

                    if (is_null($regions[$region])) break;

                    $content[$region] = $this->sectionResolver($regions[$region]->section_schema, $page->page_content[$region] ?? [], $post);
                    $content[$region]['id'] = $regions[$region]->slug;

                    // dd($regions);
                    break;
            }
        }

        // dd($schema, $regions, $content, $post);

        return view('exryze.layout.index', compact('schema', 'regions', 'content', 'post', 'meta'));
    }

    public function page(Request $request, String|null $slug = null)
    {
        if (!$slug) {
            $slug = app(GeneralSettingsService::class)->get('navigation.home.page.slug');

            if (!$slug) {
                return abort(404);
            }
        }

        $page = Page::whereNotNull('published_at')->where('slug', $slug)->firstOrFail();

        return $this->layoutResolver($request, $page);
    }

    public function post(Request $request, String $type, String $slug)
    {
        $post = Post::where('slug', $slug)
            ->with(['cover', 'type', 'categories', 'tags', 'author'])
            ->whereHas('type', function ($query) use ($type) {
                $query->where('slug', $type)
                    ->where('page_schema->enable', true);
            })
            ->firstOrFail();
        $page = Page::where('id', $post->type->page_schema['page_id'])->firstOrFail();

        return $this->layoutResolver($request, $page, $post);
    }
}
