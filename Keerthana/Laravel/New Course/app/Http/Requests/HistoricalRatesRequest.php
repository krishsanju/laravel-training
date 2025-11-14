<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoricalRatesRequest extends FormRequest
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
            'source' => 'nullable|string|size:3',
            'currencies' => 'required|string',
            'start_date' => 'nullable|date|after_or_equal:2005-01-01',
            'end_date'   => 'nullable|date|before_or_equal:2025-12-31',
        ];
    }
}
