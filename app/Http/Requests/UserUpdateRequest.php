<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('user')->id === Auth::user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'alpha-num',
                Rule::unique('users')->ignore($this->route('user'))
            ],
            'first_name' => 'alpha',
            'last_name' => 'alpha',

            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users')->ignore($this->route('user'))
            ],

            'password' => [
                'sometimes',
                'required',
                'confirmed',
                'min:6',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
            ],
            'old_password' => 'required_with:password|password',

            'avatar' => 'image',
            'description' => 'nullable',
            'facebook_url' => 'url|regex:/^https:\/\/www.facebook.com\//',
            'instagram_url' => 'url|regex:/^https:\/\/www.instagram.com\//',
            'twitter_url' => 'url|regex:/^https:\/\/twitter.com\//',
            'youtube_url' => 'url|regex:/^https:\/\/www.youtube.com\//',
        ];
    }
}
