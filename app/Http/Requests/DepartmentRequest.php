<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            'department_name' => 'required',
            'department_head' => 'required',
            'email' => 'required|email',
            'contact_number' => ['required','regex:/^(09|\+639)\d{9}$/', 'min:11'],
        ];
    }

    public function messages(): array{
        return [
            "contact_number.regex" => 'Please enter a valid mobile number', 
            "contact_number.min" => 'Please enter a valid mobile number', 
        ];
    }
}
