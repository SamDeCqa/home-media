<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('user')->get();

        return CategoryResource::collection($categories);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $user = $request->user();

        if (!$user->isAdmin()) {
            $request->request->remove('is_private');
        }

        $data = $request->validated();

        $category = $user->categories()->create($data); //KWANINI HII MWISHO WA SIKU INARUDISHA IS_PRIVATE NULL KWENYE HII METHOD???
        
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('media');
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $user = $request->user();

        if (!$user->isAdmin()) {
            $request->request->remove('is_private');
        }

        $data = $request->validated();

        $category->update($data);

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'status' => 'succes',
            'message' => 'Category deleted successfully'
        ]);
    }
}
