<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Spatie\PdfToImage\Pdf;

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
    }

    private function fromVideo(Media $media)
    {
        $thumbnail = $this->thumbnailPath();

        FFMpeg::fromDisk('local_server')
            ->open($media->path)
            ->getFrameFromSeconds(1)
            ->export()
            ->toDisk('local')
            ->save($thumbnail);

        return $thumbnail;
    }

    private function fromPdf(Media $media)
    {
        $thumbnail = $this->thumbnailPath();
        $pdf = new Pdf(
            Storage::disk('local_server')->path($media->path)
        );

        $pdf->thumbnailSize($this->height, $this->width)
            ->save(
                Storage::disk('local')->path($thumbnail)
            );

        return $thumbnail;
    }

    private function thumbnailPath()
    {
        return 'thumbnails/' . Str::uuid() . '.jpg';
    }
}
