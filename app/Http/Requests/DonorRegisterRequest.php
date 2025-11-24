<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonorRegisterRequest extends FormRequest
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
            "first_name" => 'required',
            "last_name" => 'required',
            "middle_name" => 'nullable',
            "suffix" => 'nullable',
            "email" => 'required|email|unique:donors,email',
            "contact_number" => ['required','regex:/^(09|\+639)\d{9}$/', 'min:11'],
            "birth_date" => 'required',
            "gender" => 'required',
            "civil_status" => 'required',
            "province" => 'required',
            "city" => 'required',
            "barangay" => 'required',
            "blood_type" => 'required',
        ];
    }
}
