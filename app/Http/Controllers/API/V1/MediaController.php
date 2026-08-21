<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\MediaType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Jobs\ProcessMedia;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        // Scope check: Visible if public OR owned by current user
        $isAccessible = fn($q) => $q->where('is_private', false)
            ->orWhere('user_id', $userId);

        $query = Media::query()
            ->with([
                'category' => fn($q) => $q->where($isAccessible),
                'tags'     => fn($q) => $q->where($isAccessible),
            ])
            // 2. Ensure only accessible media is returned
            ->where($isAccessible);

        // Filter: Media created by current user
        $query->when(
            $request->boolean('by_me'),
            fn($q) => $q->where('user_id', $userId)
        );

        // Filter: By Category Name (Scoped to visible categories)
        $query->when(
            $request->filled('category'),
            fn($q) => $q->whereHas('category', function ($inner) use ($request, $isAccessible) {
                $inner->where($isAccessible)
                    ->where('name', 'ilike', '%' . $request->category . '%');
            })
        );

        // Filter: Search in Media Name OR Tag Name (Scoped to visible tags)
        $query->when(
            $request->filled('search'),
            fn($q) => $q->where(function ($searchQuery) use ($request, $isAccessible) {
                $searchQuery->where('name', 'ilike', '%' . $request->search . '%')
                    ->orWhereHas('tags', function ($tagQuery) use ($request, $isAccessible) {
                        $tagQuery->where($isAccessible)
                            ->whereIn('name', 'ilike', '%' . $request->search . '%');
                    });
            })
        );

        $media = $query->cursorPaginate(70);

        return MediaResource::collection($media);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMediaRequest $request, FileReceiver $receiver)
    { //NAHITAJI name, content-type, descr, is_favorite, is_priv, byte_size, metadata
        //pokea media
        $request->validated();
        
        $save = $receiver->receive();

        if($save->isFinished()){
            return $this->saveFile($save->getFile(), $request);
        }

        //KAMA BADO HAIJAMALIZA KU-SAVE
        $handler = $save->handler();

        Log::info($handler->getPercentageDone());

        //assign categories specified na user
        //assign tags specified na user
        //extract meta data ujue size yake
        //kama size ni kubwa >10Mb send kwenye background queue
        //rudisha media resource ya hiyo media stored
    }
 

    /**
     * Saves the completed, merged file to permanent storage.
    */
    protected function saveFile(UploadedFile $file, Request $request): JsonResponse
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName()); // remove extension
        $fileName .= '_' . md5(time()) . '.' . $extension; // create unique name
        
        // Store file in app/public/media
        $path = $file->storeAs('media', $fileName, 'server_local');

        $user = $request->user();

         $media =  $user->media()->create([
            'name' => $file->getFilename(),
            'path' => $path,
            'disk' => 'server_local',
            'content_type'=> $file->getMimeType(),
            'description' => $request->description,
            'byte_size' => $file->getSize(),
            'metadata' => null,
            'is_favorite' => $request->is_favorite ?? false,
            'is_private' => $request->is_private ?? true
        ]);

        $preferences = ['description' => $request->description, 'is_private' => $request->is_private, 'is_favorite' => $request->is_favorite];
        
        dispatch(new ProcessMedia($media->id));
        // Delete temporary chunk metadata once saved
        unlink($file->getPathname());

        return response()->json([
            // 'path' => $path,
            'name' => $fileName,
            'mime_type' => $preferences,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $medium)
    {
        $medium->load(['category']);
        return new MediaResource($medium);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMediaRequest $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        $media->delete();

        return response()->json([
            'status' => 'succes',
            'message' => 'Media was deleted successfully'
        ]);
    }
}
