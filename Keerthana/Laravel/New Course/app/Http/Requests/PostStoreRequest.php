<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=> 'required|max:50',
            'image_path' => 'nullable|image',
            'tags' => 'nullable|string',
            'description' => 'required|string',
        ];
    }

    public function messages(): array{
        return [
            'title'=> 'Title is required and don\'t exceed 20 characters',
            'image'=> 'File should be image only',
            'description'=> 'Description is required',
        ];
    }

}
