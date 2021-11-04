<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeStoreRequest;
use App\Http\Resources\RecipeResource;
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
        $recipeData = array_merge($request->validated(), ['user_id' => auth()->user()->id]);

        $recipe = Recipe::create($recipeData);
        if ($request->has('ingredients')) $recipe->ingredients()->createMany($recipeData['ingredients']);
        if ($request->has('steps')) $recipe->steps()->createMany($recipeData['steps']);
        if ($request->has('categories')) $recipe->categories()->sync($recipeData['categories']);
        if ($request->has('nutrient')) $recipe->nutrient()->create($recipeData['nutrient']);

        return response(['message' => 'success']);
    }

    public function show(Recipe $recipe)
    {
        return RecipeResource::make($recipe);
    }

    public function update(Request $request, Recipe $recipe)
    {
        //
    }

    public function destroy(Recipe $recipe)
    {
        //
    }
}
