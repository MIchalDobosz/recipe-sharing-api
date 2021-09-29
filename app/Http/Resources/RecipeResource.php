<?php

namespace App\Http\Resources;

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
            'nutrients' => NutrientResource::make($this->nutrient),
            'ingredients' => IngredientResource::collection($this->ingredients),
            'steps' => StepResource::collection($this->steps),
            'comments' => CommentResource::collection($this->comments),
        ];
    }
}
