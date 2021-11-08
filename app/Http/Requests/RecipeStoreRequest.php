<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RecipeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'nullable',
            'content' => 'required',
            'main_image' => 'image',
            'ingredients' => 'required|array',
            'ingredients.*' => 'required',
            'ingredients.*.name' => 'required',
            'ingredients.*.quantity' => 'required_|numeric',
            'ingredients.*.unit' => 'required',
            'steps' => 'required|array',
            'steps.*' => 'required',
            'steps.*.content' => 'required',
            'categories' => 'required|array',
            'categories.*' => 'required|numeric|exists:categories,id',
            'images' => 'array',
            'images.*' => 'image',
            'preparation_time' => 'nullable',
            'difficulty' => 'required',
            'servings' => 'nullable',
            'nutrients' => 'nullable',
            'nutrients.calories' => 'numeric',
            'nutrients.carbs' => 'numeric',
            'nutrients.protein' => 'numeric',
            'nutrients.fat' => 'numeric',
        ];
    }
}
