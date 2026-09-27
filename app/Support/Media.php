<?php

namespace App\Support;

use Illuminate\Support\Str;

class Media
{
    /**
     * Resolve a stored image reference to a public delivery URL.
     *
     * Accepts: Cloudinary public_ids (`les-renang/…`, served from the CDN with
     * f_auto,q_auto), absolute URLs (returned as-is), static theme paths under
     * `assets/…` (served from /public), and legacy local uploads (served from
     * the `storage` symlink).
     */
    public static function url(?string $value, ?string $fallback = null): ?string
    {
        if (blank($value)) {
            return $fallback ? asset(ltrim($fallback, '/')) : null;
        }

        if (Cloudinary::configured() && Cloudinary::isId($value)) {
            return Cloudinary::url($value);
        }

        if (Str::startsWith($value, ['http://', 'https://', '//'])) {
            return $value;
        }

        if (Str::startsWith($value, ['assets/', '/assets/'])) {
            return asset(ltrim($value, '/'));
        }

        return asset('storage/' . ltrim($value, '/'));
    }

    /**
     * Resolve a stored video reference (e.g. Hero.video_background) to a
     * delivery URL. Cloudinary public_ids use the video pipeline; legacy local
     * paths and absolute URLs fall back to url().
     */
    public static function videoUrl(?string $value, ?string $fallback = null): ?string
    {
        if (Cloudinary::configured() && Cloudinary::isId($value)) {
            return Cloudinary::url($value, 'video');
        }

        return self::url($value, $fallback);
    }
}
