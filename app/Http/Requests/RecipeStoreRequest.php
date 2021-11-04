<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'slug' => 'required',
            'content' => 'required',
            'ingredients.*.name' => 'sometimes|required',
            'ingredients.*.quantity' => 'sometimes|required|numeric',
            'ingredients.*.unit' => 'sometimes|required',
            'steps.*.content' => 'sometimes|required',
            'categories' => 'required|array',
            'nutrient.calories' => 'sometimes|required',
            'nutrient.protein' => 'sometimes|required',
            'nutrient.carbs' => 'sometimes|required',
            'nutrient.fat' => 'sometimes|required',
            'servings' => 'required',
            'preparation_time' => 'required',
            'difficulty' => 'required'
        ];
    }
}
