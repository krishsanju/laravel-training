<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoryDataRequest extends FormRequest
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
            // 'latitude' => 'required|numeric',
            // 'longitude' => 'required|numeric',
            'city' => 'required|string',
            'daily' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            // 'cnt' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'city.required' => 'City is required',
            'daily.required' => 'Daily parameter is required',
            'start_date.required' => 'Start date is required',
            'end_date.required' => 'End date is required',
            'start_date.date' => 'Start date must be a valid date',
            'end_date.date' => 'End date must be a valid date',
            // 'cnt.required' => 'Count is required',
        ];
    }
}
