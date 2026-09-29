<?php

namespace App\Support;

use App\Models\AboutUs;
use App\Models\Blogs;
use App\Models\client;
use App\Models\contact;
use App\Models\FAQ;
use App\Models\gallery;
use App\Models\Hero;
use App\Models\Instructor;
use App\Models\Program;
use App\Models\Service;
use App\Models\Stats;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Single source of truth for the shapes the public React frontend consumes.
 * Both HomeController and PageController render sections from here, so a column
 * or mapping change lives in one place. Every table may be empty (content is
 * admin-managed) — the React components carry the visual fallbacks.
 */
class Content
{
    public static function hero(): ?array
    {
        $hero = Hero::query()
            ->when(self::hasColumn('heroes', 'is_active'), fn ($q) => $q->where('is_active', true))
            ->orderBy('order')
            ->first() ?? Hero::first();

        return $hero ? [
            'title' => $hero->title,
            'subtitle' => $hero->subtitle,
            'image' => Media::url($hero->image),
            'video' => Media::videoUrl($hero->video_background),
            'cta_text' => $hero->cta_text,
            'cta_link' => $hero->cta_link,
            'secondary_cta_text' => $hero->secondary_cta_text,
            'secondary_cta_link' => $hero->secondary_cta_link,
        ] : null;
    }

    public static function about(): ?array
    {
        $about = AboutUs::first();

        return $about ? [
            'title' => $about->title,
            'description' => $about->description,
            'img' => Media::url($about->img),
        ] : null;
    }

    public static function stats(): array
    {
        return Stats::all()->map(fn ($s) => [
            'icon' => $s->icon,
            'value' => $s->value,
            'label' => $s->label,
        ])->all();
    }

    public static function services(): array
    {
        return Service::all()->map(fn ($s) => [
            'icon_class' => $s->icon_class,
            'title' => $s->title,
            'short_desc' => $s->short_desc,
            'description' => $s->description,
        ])->all();
    }

    public static function programs(int $take = 6): array
    {
        return Program::query()
            ->with(['instructor:id,name'])
            ->latest('id')
            ->take($take)
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'age_range' => $p->age_range,
                'schedule' => trim(collect([$p->day, $p->start_time, $p->end_time ? '– ' . $p->end_time : null])->filter()->implode(' ')) ?: null,
                'price' => method_exists($p, 'getFormattedPriceAttribute') ? $p->formatted_price : ($p->price ? 'Rp ' . number_format((float) $p->price, 0, ',', '.') : null),
                'thumbnail' => Media::url(is_array($p->thumbnail) ? ($p->thumbnail[0] ?? null) : $p->thumbnail),
                'description' => $p->description,
                'instructor' => optional($p->instructor)->name,
            ])->all();
    }

    public static function instructors(int $take = 8): array
    {
        return Instructor::query()->take($take)->get()->map(fn ($i) => [
            'id' => $i->id,
            'name' => $i->name,
            'specialization' => $i->specialization,
            'certification' => $i->certification,
            'photo' => Media::url($i->photo),
            'bio' => $i->bio,
            'twitter' => $i->twitter,
            'experience' => $i->pengalaman_tahun,
        ])->all();
    }

    public static function clients(): array
    {
        return client::all()->map(fn ($c) => [
            'id' => $c->id,
            'image' => Media::url($c->image),
        ])->all();
    }

    public static function gallery(int $take = 9): array
    {
        return gallery::query()->latest('id')->take($take)->get()->map(fn ($g) => [
            'id' => $g->id,
            'title' => $g->title,
            'image' => Media::url($g->image),
        ])->all();
    }

    public static function faqs(): array
    {
        return FAQ::all()->map(fn ($f) => [
            'id' => $f->id,
            'question' => $f->question,
            'answer' => $f->answer,
        ])->all();
    }

    public static function blogs(int $take = 3): array
    {
        return Blogs::query()->with('categories')->latest('id')->take($take)->get()
            ->map(fn ($b) => self::blogCard($b))->all();
    }

    /** Blog list-card shape (real columns: imgUrl / short_desc / description / categories_id). */
    public static function blogCard(Blogs $b): array
    {
        return [
            'id' => $b->id,
            'title' => $b->title,
            'image' => Media::url($b->imgUrl),
            'excerpt' => Str::limit(trim(strip_tags((string) ($b->short_desc ?: $b->description))), 140),
            'category' => optional($b->categories)->name,
            'date' => optional($b->created_at)->translatedFormat('d M Y'),
        ];
    }

    /** Full article shape for the detail page. */
    public static function blogDetail(Blogs $b): array
    {
        return [
            'id' => $b->id,
            'title' => $b->title,
            'image' => Media::url($b->imgUrl),
            'short_desc' => $b->short_desc,
            'content' => $b->description,
            'category' => optional($b->categories)->name,
            'date' => optional($b->created_at)->translatedFormat('d M Y'),
        ];
    }

    /** Site-wide contact info (model `contact` → table `contacts`). Shared globally. */
    public static function site(): array
    {
        $c = contact::first();

        return [
            'address' => $c->address ?? null,
            'phone' => $c->phone ?? null,
            'email' => $c->email ?? null,
            'whatsapp' => $c->whatsapp_number ?? null,
            'whatsapp_message' => $c->whatsapp_message ?? null,
            'social' => $c->social ?? null, // json → array (key => url)
        ];
    }

    /** Guard against filtering on a column missing from older schemas. */
    private static function hasColumn(string $table, string $column): bool
    {
        try {
            return Schema::hasColumn($table, $column);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
