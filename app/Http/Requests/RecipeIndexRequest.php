<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeIndexRequest extends FormRequest
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
            'categories' => 'nullable|array',
            'categories.*' => 'required_with:categories|numeric',
            'servings' => 'nullable|numeric',
            'difficulty' => 'nullable|numeric',
            'preparation_time' => 'nullable|numeric',
        ];
    }
}
