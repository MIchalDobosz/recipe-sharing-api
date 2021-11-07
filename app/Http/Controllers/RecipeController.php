<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeStoreRequest;
use App\Http\Requests\RecipeUpdateRequest;
use App\Http\Resources\RecipeResource;
use App\Models\File;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        return RecipeResource::collection(Recipe::all());
    }

    public function store(RecipeStoreRequest $request)
    {
        $recipe = Recipe::create(array_merge($request->all(), ['user_id' => auth()->user()->id]));
        if ($request->has('main_image')) $recipe->images()->create(File::store($request->main_image, 'public', 'main_images'), ['main' => true]);
        if ($request->has('ingredients')) $recipe->ingredients()->createMany($request->ingredients);
        if ($request->has('steps')) $recipe->steps()->createMany($request->steps);
        if ($request->has('categories')) $recipe->categories()->sync($request->categories);
        if ($request->has('nutrient')) $recipe->nutrient()->create($request->nutrient);
        if ($request->has('images')) $recipe->images()->createMany(File::store($request->images, 'public', 'images'));

        return response(['message' => 'success']);
    }

    public function show(Recipe $recipe)
    {
        return RecipeResource::make($recipe);
    }

    public function update(RecipeUpdateRequest $request, Recipe $recipe)
    {
        $recipe->update($request->all());

        return response(['message' => 'success']);
    }

    public function destroy(Recipe $recipe)
    {
        //
    }
}
