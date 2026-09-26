<?php

namespace App\Console\Commands;

use Cloudinary\Cloudinary;
use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

/**
 * One-time (idempotent) upload of static theme assets under public/assets/img
 * to Cloudinary, so the React frontend can deliver them via CDN + f_auto/q_auto.
 *
 * public_id mirrors the path relative to public/assets/img (no extension),
 * prefixed with the `les-renang/` folder — matching the frontend `cld()` helper.
 * Re-runnable: overwrite=true refreshes existing assets.
 */
class CloudinarySyncAssets extends Command
{
    protected $signature = 'cloudinary:sync-assets {--dry : List what would upload without uploading}';

    protected $description = 'Upload public/assets/img/** to Cloudinary (folder les-renang)';

    private const BASE = 'assets/img';
    private const FOLDER = 'les-renang';
    private const EXT = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

    public function handle(): int
    {
        $url = config('services.cloudinary.url');
        if (blank($url)) {
            $this->error('CLOUDINARY_URL is not set in .env');
            return self::FAILURE;
        }

        $root = public_path(self::BASE);
        if (! is_dir($root)) {
            $this->error("Directory not found: {$root}");
            return self::FAILURE;
        }

        $finder = (new Finder())->files()->in($root)->name(array_map(fn ($e) => "*.{$e}", self::EXT));
        $total = $finder->count();
        if ($total === 0) {
            $this->warn('No images found.');
            return self::SUCCESS;
        }

        $this->info("Found {$total} image(s) under {$root}");
        $cloudinary = new Cloudinary($url);
        $bar = $this->output->createProgressBar($total);
        $ok = 0;
        $failed = [];

        foreach ($finder as $file) {
            $rel = str_replace('\\', '/', $file->getRelativePathname());     // teacher/abo-1.jpg
            $publicId = self::FOLDER . '/' . preg_replace('/\.[^.]+$/', '', $rel); // les-renang/teacher/abo-1

            if ($this->option('dry')) {
                $this->line("  {$rel}  ->  {$publicId}");
                continue;
            }

            try {
                $cloudinary->uploadApi()->upload($file->getRealPath(), [
                    'public_id' => $publicId,
                    'overwrite' => true,
                    'resource_type' => 'image',
                    'invalidate' => true,
                ]);
                $ok++;
            } catch (\Throwable $e) {
                $failed[] = "{$rel}: {$e->getMessage()}";
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Uploaded {$ok}/{$total} to cloud '" . config('services.cloudinary.cloud_name') . "' folder '" . self::FOLDER . "'.");

        if ($failed) {
            $this->warn('Failed:');
            foreach ($failed as $f) {
                $this->line("  - {$f}");
            }
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }
}
