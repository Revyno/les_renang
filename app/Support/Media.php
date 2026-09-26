<?php

namespace App\Support;

use Illuminate\Support\Str;

class Media
{
    /**
     * Resolve a stored image reference to a public delivery URL.
     *
     * Accepts: absolute URLs (returned as-is), static theme paths under
     * `assets/…` (served from /public), and Filament uploads (served from the
     * `storage` symlink). Matches the existing Hero::getImageUrlAttribute convention.
     *
     * ponytail: Cloudinary not wired yet. When CLOUDINARY_CLOUD_NAME is set and
     * assets are uploaded, branch here to res.cloudinary.com/<cloud>/… before the
     * storage fallback. Upgrade path: PRD Phase 2.
     */
    public static function url(?string $value, ?string $fallback = null): ?string
    {
        if (blank($value)) {
            return $fallback ? asset(ltrim($fallback, '/')) : null;
        }

        if (Str::startsWith($value, ['http://', 'https://', '//'])) {
            return $value;
        }

        if (Str::startsWith($value, ['assets/', '/assets/'])) {
            return asset(ltrim($value, '/'));
        }

        return asset('storage/' . ltrim($value, '/'));
    }
}
