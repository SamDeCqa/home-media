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
        $query = Media::query()->with(['category', 'tags']) //???????????: JE NAWEZA PATA MEDIA ALIZOWEKA ADMIN ZIWE AVAILABLE PUBLICLY KWA KILA MEMBER
        ->where(
            fn($q) => $q->where(
                    fn($inner) => $inner->where(
                        'user_id',
                        '=',
                        null
                        )
                        ->orWhereRelation(
                        'category',
                        'user_id',
                        '=',
                        null
                    )
                        ->orWhereRelation(
                            'tags',
                            'user_id',
                            '=',
                            null
                        )
                )
        )
        ->orWhereNot(
                fn($q) => $q->where(
                    fn($inner) => $inner->where(
                        'user_id',
                        '!=',
                        $request->user()->id 
                        )
                        ->orWhereRelation(
                        'category',
                        'user_id',
                        '!=',
                        $request->user()->id //HAKUNA KUCHUKUA MEDIA ZA CATEGORY AMBAYO USER HUSIKA HAJAITENGENEZA YEYE
                    )
                        ->orWhereRelation(
                            'tags',
                            'user_id',
                            '!=',
                            $request->user()->id //HAKUNA KUCHUKUA MEDIA ZENYE TAGS AMBAZO USER HUSIKA HAKUZITENGENEZA YEYE
                        )
                )
            );

        $query->when(
            $request->has('by_me'), //KUPATA MEDIA ZOTE ALIZOHIFADHI USER
            fn($q) => $q->where('user_id', $request->user()->id)
            /* fn($q) => $q->where(
                fn($inner) => $inner->where('user_id', $request->user()->id)//MEDIA ZENYE HIYO USER ID
                    ->orWhereRelation(
                        'category',
                        'user_id',
                        '=',
                        $request->user()->id//MEDIA AMBAYO SIO YA HUYO USER ILA YEYE AMEI-CATEGORISE KIVYAKE
                    )
            )*/
        );

        $query->when(
            $request->filled('category'),
            fn($inner) => $inner->whereRelation(
                'category',
                'name',
                'ilike',
                '%' . $request->category . '%' //MEDIA ILIYOPO CATEGORY FLANI
            )
        );

        $query->when(
            $request->filled('tags'),
            fn($inner) => $inner->whereRelation(
                'tags',
                'name',
                'ilike',
                '%' . $request->tags . '%' //MEDIA ILIYOPEWA TAG FLANI
            )
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
