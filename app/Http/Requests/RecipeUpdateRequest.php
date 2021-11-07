<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RecipeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('recipe')->user_id === Auth::user()->id;
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
            'ingredients.*.name' => 'required_with:ingredients',
            'ingredients.*.quantity' => 'required_with:ingredients|numeric',
            'ingredients.*.unit' => 'required_with:ingredients',
            'steps.*.content' => 'required_with:steps',
            'categories' => 'required|array',
            'categories.*' => 'required|numeric|exists:categories,id',
            'images.*' => 'image',
            'preparation_time' => 'nullable',
            'difficulty' => 'nullable',
            'servings' => 'nullable',
            'nutrients' => 'nullable'
        ];
    }
}
