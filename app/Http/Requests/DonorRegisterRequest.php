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
            "email" => 'required|email|unique:users,email',
            "contact_number" => ['required','regex:/^(09|\+639)\d{9}$/', 'min:11'],
            "birth_date" => 'required',
            "address" => 'required',
            "confirmEmail" => 'required|same:email',
            "password" => 'required|min:8|confirmed',
        ];
    }
    
    public function messages()
    {
        return [
            "confirmEmail.same" => "The confirm email and email must match.",
            "confirmEmail.required" => "Please confirm you email address.",
        ];
    }
}
