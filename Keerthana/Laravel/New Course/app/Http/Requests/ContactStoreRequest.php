<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:10',
            'email'=> 'required|email',
            'subject' => 'nullable|max:50', 
            'message'=> ['required', 'max:500'],
        ];
    }

    public function messages(): array{  //custom messages
        return [
            'name'=> 'Name proper gaa fill chai',
            'email.required'=> 'submit chesa mundhu edho oka email evu',
            'email.email' => 'email echavu okay but, correct ga evali kadha'
        ];
    }
}
