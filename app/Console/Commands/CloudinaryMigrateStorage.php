<?php

namespace App\Console\Commands;

use App\Support\Cloudinary;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * One-time, idempotent migration of local CMS media (stored in /storage) to
 * Cloudinary. Uploads each referenced file and rewrites the DB column to the
 * Cloudinary public_id. Private/PII uploads (payment proofs, student photos)
 * are intentionally excluded — they stay on local storage.
 *
 * Re-runnable: rows already holding a Cloudinary public_id are skipped.
 */
class CloudinaryMigrateStorage extends Command
{
    protected $signature = 'cloudinary:migrate-storage {--dry : List what would migrate without uploading}';

    protected $description = 'Upload existing local CMS images/videos to Cloudinary and update DB references';

    /** [modelClass, column, resourceType, isArray, folderSuffix] */
    private const MAP = [
        [\App\Models\Hero::class,       'image',            'image', false, 'hero'],
        [\App\Models\Hero::class,       'video_background', 'video', false, 'hero'],
        [\App\Models\AboutUs::class,    'img',              'image', false, 'about'],
        [\App\Models\Program::class,    'thumbnail',        'image', true,  'programs'],
        [\App\Models\Instructor::class, 'photo',            'image', false, 'instructors'],
        [\App\Models\Blogs::class,      'imgUrl',           'image', false, 'blogs'],
        [\App\Models\gallery::class,    'image',            'image', false, 'gallery'],
        [\App\Models\Teams::class,      'imgUrl',           'image', false, 'teams'],
        [\App\Models\Ad::class,         'image',            'auto',  false, 'ads'],
        [\App\Models\client::class,     'image',            'image', false, 'clients'],
    ];

    public function handle(): int
    {
        if (! Cloudinary::configured()) {
            $this->error('Cloudinary not configured (set CLOUDINARY_CLOUD_NAME and CLOUDINARY_URL in .env).');
            return self::FAILURE;
        }

        $dry = (bool) $this->option('dry');
        $migrated = $skipped = $failed = 0;

        foreach (self::MAP as [$modelClass, $column, $type, $isArray, $suffix]) {
            $folder = Cloudinary::FOLDER . '/cms/' . $suffix;
            $this->line("<info>{$modelClass}.{$column}</info>  ->  {$folder}");

            $modelClass::query()->whereNotNull($column)->each(
                function (Model $row) use ($column, $type, $isArray, $folder, $dry, &$migrated, &$skipped, &$failed) {
                    $value = $row->getAttribute($column);
                    $paths = $isArray ? (array) $value : [$value];
                    $out = [];
                    $changed = false;

                    foreach ($paths as $path) {
                        if (blank($path) || Cloudinary::isId($path)) {
                            $out[] = $path;
                            $skipped++;
                            continue;
                        }

                        $real = $this->localRealPath($path);
                        if ($real === null) {
                            $this->warn("  MISSING file for [{$row->getKey()}]: {$path}");
                            $out[] = $path;
                            $failed++;
                            continue;
                        }

                        if ($dry) {
                            $this->line("  would upload [{$row->getKey()}]: {$path}");
                            $out[] = $path;
                            $migrated++;
                            continue;
                        }

                        try {
                            $out[] = Cloudinary::upload($real, $folder, $type);
                            $changed = true;
                            $migrated++;
                        } catch (\Throwable $e) {
                            $this->warn("  FAILED [{$row->getKey()}] {$path}: {$e->getMessage()}");
                            $out[] = $path;
                            $failed++;
                        }
                    }

                    if ($changed) {
                        $row->setAttribute($column, $isArray ? $out : $out[0]);
                        $row->save();
                    }
                }
            );
        }

        $this->newLine();
        $this->info(($dry ? '[DRY] ' : '') . "Done. migrated={$migrated} skipped={$skipped} failed={$failed}");

        return $failed ? self::FAILURE : self::SUCCESS;
    }

    /** Locate a stored path on the public disk, then the local disk. */
    private function localRealPath(string $path): ?string
    {
        foreach (['public', 'local'] as $disk) {
            if (Storage::disk($disk)->exists($path)) {
                return Storage::disk($disk)->path($path);
            }
        }

        return null;
    }
}
