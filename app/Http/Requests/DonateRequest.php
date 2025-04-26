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
            "qnty" => 'required',
            "blood_bag_id" => 'required_with:qnty|array',
            "blood_bag_id.*" => 'required|unique:donation_histories,blood_bag_id',
            "volume_ml" => 'required_with:qnty|array',
            "volume_ml.*" => 'required',
            "date_process" => 'required|date',
            "province" => 'required',
            "city" => 'required',
            "barangay" => 'required',
            "staff_id" => 'required',
            "donation_type" => 'required',
            'expiration_setting_type' => 'required|integer|in:1,2',
            'expiration_date' => [
                'required_if:expiration_setting_type,1',
                'nullable',
                'date',   
            ],
            'expiration_days' => 'required_if:expiration_setting_type,2'
        ];
    }

    public function messages(): array{
        return [
            'staff_id.required' => 'Please select staff / nurse',
            'blood_bag_id.unique' => 'Blood bag ID already exists',
            'volume_ml.*.required' => 'This field is required',
            'blood_bag_id.*.required' => 'This field is required',
            'blood_bag_id.*.unique' => 'Please input unique blood blag ID',
            'expiration_setting_type.required' => 'Please select Expiration Setting Type',
            'expiration_date.required_if' => 'Please enter expiration days',
            'expiration_days.required_if' => 'Please enter number of days',
        ];
    }
}
