<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvertCurrencyRequest extends FormRequest
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
            'from'   => ['required', 'string', 'size:3'],
            'to'     => ['required', 'string', 'size:3', 'different:from'],
            'amount' => ['required', 'numeric', 'min:0.000001'],
        ];
    }

    public function messages()
    {
        return [
            'from.size'   => '"from" must be a 3-letter currency code.',
            'to.size'     => '"to" must be a 3-letter currency code.',
            'to.different'=> '"to" must be different from "from".',
            'amount.min'  => '"amount" must be a positive number.',
        ];
    }
}
