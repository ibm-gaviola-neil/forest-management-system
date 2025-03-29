<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonateRequest extends FormRequest
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
            "blood_bag_id" => 'required|unique:donation_histories,blood_bag_id',
            "volume_ml" => 'required',
            "qnty" => 'required',
            "date_process" => 'required',
            "province" => 'required',
            "city" => 'required',
            "barangay" => 'required',
            "staff_id" => 'required',
            "donation_type" => 'required',
        ];
    }

    public function messages(): array{
        return [
            'staff_id.required' => 'Please select staff / nurse',
            'blood_bag_id.unique' => 'Blood bag ID already exists'
        ];
    }
}
