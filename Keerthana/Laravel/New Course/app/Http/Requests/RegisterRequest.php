<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:15|min:3',        
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            // 'role' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'email.required' => 'A email is required',
        ];
    }

}
