<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'place' => 'required|min:3|max:50|string',
            'country' => 'required|min:2|max:50|string',
            'city' => 'required|min:2|max:50|string',
            'description' => 'required',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categories' => 'array|min:1|required'
        ];
    }

    public function attributes(): array
    {
        return [
            'images.*' => 'image',
            'categories' => 'category',
        ];
    }

    public function messages(): array
    {
        return [
            'images.*.image' => 'The file must be an image.',
            'images.*.mimes' => 'The file must be a file of type: jpeg, png, jpg, gif, svg.',
            'images.*.max' => 'The file may not be greater than 2048 kilobytes.',
            'categories.required' => 'You need to choose at least one category.',
        ];
    }
}
