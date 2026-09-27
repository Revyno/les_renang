<?php

namespace App\Support;

use Cloudinary\Cloudinary as CloudinarySdk;
use Illuminate\Support\Str;

/**
 * Thin wrapper around cloudinary/cloudinary_php for CMS media.
 *
 * DB stores the returned public_id (prefixed `les-renang/`); delivery URLs are
 * built on read. Mirrors the folder/SDK convention of CloudinarySyncAssets.
 */
class Cloudinary
{
    /** Folder prefix that also marks a stored value as a Cloudinary public_id. */
    public const FOLDER = 'les-renang';

    public static function configured(): bool
    {
        return filled(config('services.cloudinary.cloud_name'))
            && filled(config('services.cloudinary.url'));
    }

    /** True when $value is a Cloudinary public_id (vs a legacy local path). */
    public static function isId(?string $value): bool
    {
        return filled($value) && Str::startsWith($value, self::FOLDER . '/');
    }

    private static function sdk(): CloudinarySdk
    {
        return new CloudinarySdk(config('services.cloudinary.url'));
    }

    /** Delivery type is concrete; `auto` (upload-only) is served as image. */
    private static function deliveryType(string $resourceType): string
    {
        return $resourceType === 'video' ? 'video' : 'image';
    }

    /**
     * Upload a local file. $folder is the Cloudinary folder (e.g.
     * `les-renang/cms/hero`); Cloudinary appends a unique name and returns the
     * full public_id to store in the DB.
     */
    public static function upload(string $realPath, string $folder, string $resourceType = 'image'): string
    {
        $result = self::sdk()->uploadApi()->upload($realPath, [
            'folder'        => $folder,
            'resource_type' => $resourceType,
            'invalidate'    => true,
        ]);

        return $result['public_id'];
    }

    public static function destroy(string $publicId, string $resourceType = 'image'): void
    {
        self::sdk()->uploadApi()->destroy($publicId, [
            'resource_type' => self::deliveryType($resourceType),
            'invalidate'    => true,
        ]);
    }

    /** Build a delivery URL (f_auto,q_auto) from a stored public_id. */
    public static function url(?string $publicId, string $resourceType = 'image', string $transforms = 'f_auto,q_auto'): ?string
    {
        if (blank($publicId)) {
            return null;
        }

        $cloud = config('services.cloudinary.cloud_name');
        $type  = self::deliveryType($resourceType);

        return "https://res.cloudinary.com/{$cloud}/{$type}/upload/{$transforms}/{$publicId}";
    }
}
