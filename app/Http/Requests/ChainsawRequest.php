<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChainsawRequest extends FormRequest
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
            'serial_number' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'bar_length' => 'required|numeric',
            'engine_displacement' => 'required|numeric|min:2',
            'date_acquisition' => 'required|date',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'serial_number.required' => 'Serial Number is required.',
            'serial_number.string' => 'Serial Number must be a string.',
            'serial_number.max' => 'Serial Number must not exceed 255 characters.',

            'brand.required' => 'Brand is required.',
            'brand.string' => 'Brand must be a string.',
            'brand.max' => 'Brand must not exceed 255 characters.',

            'model.required' => 'Model is required.',
            'model.string' => 'Model must be a string.',
            'model.max' => 'Model must not exceed 255 characters.',

            'bar_length.required' => 'Bar Length is required.',
            'bar_length.numeric' => 'Bar Length must be a numeric value.',

            'engine_displacement.required' => 'Engine Displacement is required.',
            'engine_displacement.numeric' => 'Engine Displacement must be a numeric value.',

            'date_acquisition.required' => 'Date of Acquisition is required.',
            'date_acquisition.date' => 'Date of Acquisition must be a valid date.',

            'description.string' => 'Description must be a string.',
        ];
    }
}
