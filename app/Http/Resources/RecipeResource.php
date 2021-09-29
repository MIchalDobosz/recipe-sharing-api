<?php

namespace App\Http\Resources;

use Carbon\CarbonInterval;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $description = ($this->description) ?? Str::substr($this->content, 0, 150);

        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $description,
            'content' => $this->content,
            'difficulty' => config('properties.difficulty.' . $this->difficulty),
            'servings' => $this->servings,
            'preparation_time' => CarbonInterval::seconds($this->preparation_time)->cascade()->format('%h:%i'),
            'nutrients' => NutrientResource::make($this->nutrient),
            'categories' => CategoryResource::collection($this->categories),
            'ingredients' => IngredientResource::collection($this->ingredients),
            'steps' => StepResource::collection($this->steps),
            'comments' => CommentResource::collection($this->comments),
        ];
    }
}
