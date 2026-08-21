<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Intervention\Image\Laravel\Facades\Image;
use Spatie\PdfToImage\Pdf;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ThumbnailGenerator
{
    private int $height;
    private int $width;
    private int $quality;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->height = config('thumbnail.size.height');
        $this->width = config('thumbnail.size.width');
        $this->quality = config('thumbnail.quality');
    }

    public function generate(Media $media)
    {
        return match (true) {
            str_starts_with($media->content_type, 'image/') => $this->fromImage($media),
            str_starts_with($media->content_type, 'video/') => $this->fromVideo($media),
            str_starts_with($media->content_type, 'application/pdf') => $this->fromPdf($media),
        };
    }

private function fromImage(Media $media)
{
    $thumbnail = $this->thumbnailPath();

    $manager = new ImageManager(new Driver());

    $manager->decodePath(
        Storage::disk('public')->path($media->path)
    )
        ->cover($this->width, $this->height)
        // ->toJpeg(quality: $this->quality)
        ->save(
            Storage::disk('public')->path($thumbnail)
        );

    return $thumbnail;
}
    private function fromVideo(Media $media)
    {
        $thumbnail = $this->thumbnailPath();

        FFMpeg::fromDisk('public')
            ->open($media->path)
            ->getFrameFromSeconds(1)
            ->export()
            ->toDisk('public')
            ->save($thumbnail);

        return $thumbnail;
    }

    private function fromPdf(Media $media)
    {
        $thumbnail = $this->thumbnailPath();
        $pdf = new Pdf(
            Storage::disk('public')->path($media->path)
        );

        $pdf->thumbnailSize($this->width, $this->height)
            ->quality($this->quality)
            ->save(
                Storage::disk('public')->path($thumbnail)
            );

        return $thumbnail;
    }

    private function thumbnailPath()
    {
        return 'thumbnails/' . Str::uuid() . '.jpg';
    }
}
