<?php

namespace App\Filament\Components;

use App\Support\Cloudinary;
use Filament\Forms\Components\FileUpload;
use Livewire\TemporaryUploadedFile;

/**
 * FileUpload that stores to Cloudinary instead of a local disk.
 *
 * The model column holds the Cloudinary public_id; `->directory()` is reused as
 * the Cloudinary folder. Use `->cloudinaryResourceType('video'|'auto')` for
 * non-image uploads (default 'image').
 */
class CloudinaryUpload extends FileUpload
{
    protected string $cloudinaryResourceType = 'image';

    public function cloudinaryResourceType(string $type): static
    {
        $this->cloudinaryResourceType = $type;

        return $this;
    }

    public function getCloudinaryResourceType(): string
    {
        return $this->cloudinaryResourceType;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->saveUploadedFileUsing(function (TemporaryUploadedFile $file, CloudinaryUpload $component): ?string {
            return Cloudinary::upload(
                $file->getRealPath(),
                $component->getDirectory() ?: Cloudinary::FOLDER . '/cms',
                $component->getCloudinaryResourceType(),
            );
        });

        $this->getUploadedFileUrlUsing(function (?string $state, CloudinaryUpload $component): ?string {
            return Cloudinary::isId($state)
                ? Cloudinary::url($state, $component->getCloudinaryResourceType())
                : $state;
        });

        $this->deleteUploadedFileUsing(function (?string $file, CloudinaryUpload $component): void {
            if (Cloudinary::isId($file)) {
                Cloudinary::destroy($file, $component->getCloudinaryResourceType());
            }
        });
    }
}
