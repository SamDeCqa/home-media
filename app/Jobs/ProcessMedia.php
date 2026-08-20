<?php

namespace App\Jobs;

use App\Enums\MediaProcessingStatus;
use App\Enums\MediaType;
use App\Models\Media;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcessMedia implements ShouldQueue
{
    use Queueable;

/*private $file;
private $user;*/

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Media $media
    ) {
        /*$this->file = $file;
        $this->user = $user;*/
    }

    /**
     * Execute the job.
     */
    public function handle()
    {




        /*$storage_dir = match (true) {
            str_starts_with($mime, MediaType::IMAGE->value . '/') => 'images/',
            str_starts_with($mime, MediaType::VIDEO->value . '/') => 'videos/',
            str_starts_with($mime, MediaType::AUDIO->value . '/') => 'audio/',
            default => 'docs/',
        };*/


    $this->media->update(['processing_status' => MediaProcessingStatus::READY->value]);
        /* return response()->json([
            'is_valid'      => $file->isValid(),
            'original_name' => $file->getClientOriginalName(), //INAAMBATANISHA EXTENSION SIO
            'size_bytes'    => $file->getSize(),
            'mime_type'     => $file->getMimeType(),          // Inspected server-side
            'client_mime'   => $file->getClientMimeType(),    // Reported by browser-SIO YA KUIAMINI PIA
            'guessed_ext'   => $file->extension(),            // Safely guessed from MIME
            'client_ext'    => $file->getClientOriginalExtension(), //SIo ya kuiamini for security
            'real_path'     => $file->getRealPath(),
            'hash_name'     => $file->hashName(),
            'path_tulohifadhi' => $path
        ]);*/
    }
}
