<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Http\Controllers\Controller;
use App\Http\Requests\RatingStoreRequest;
use App\Http\Requests\RatingUpdateRequest;
use App\Models\Recipe;

class RatingsController extends Controller
{
    public function store(RatingStoreRequest $request, Recipe $recipe)
    {
        $rating = array_merge($request->validated(), ['user_id' => auth()->user()->id]);
        $recipe->ratings()->create($rating);
        $recipe->updateRating();

        return response(['message' => 'success']);
    }

    public function update(RatingUpdateRequest $request, Recipe $recipe, Rating $rating)
    {
        $rating->update($request->validated());
        $rating->recipe->updateRating();

        return response(['message' => 'success']);
    }

    public function destroy(Rating $rating)
    {
        //
    }
}
