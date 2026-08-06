<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;

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
    public function store(StoreMediaRequest $request)
    {
        //
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
