<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BloodIssuanceRequest extends FormRequest
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
            'patient_id' => 'required',
            'requestor_id' => 'required',
            'blood_type' => 'required',
            'blood_bag_id' => 'required',
            'expiration_date' => 'required|date',
            'date_of_crossmatch' => 'required|date',
            'time_of_crossmatch' => [
                'required', 
            ],
            'release_by' => 'required',
            'taken_by' => 'required',
        ];
    }

    public function messages(){
        return [
            'patient_id.required' => 'Please select patient',
            'requestor_id.required' => 'Please select requestor',
            'blood_type.required' => 'Please blood type',
            'blood_bag_id.required' => 'Please select serial number',
            'date_of_crossmatch.required' => 'Input date of crossmatch',
            'time_of_crossmatch.required' => 'Input time of crossmatch',
            'time_of_crossmatch.regex' => 'Please input correct time format ex. (9:00 AM)',
            'release_by.required' => 'Please select release in charge',
            'taken_by.required' => 'Please select person in charge',
        ];
    }
}
