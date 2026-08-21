<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ThumbnailGenerator
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
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
    }

    private function fromPdf(Media $media)
    {
        $thumbnail = $this->thumbnailPath();
    }

    private function thumbnailPath()
    {
        return 'thumbnails/' . Str::uuid() . '.jpg';
    }
}
