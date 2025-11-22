<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountSetupRequest extends FormRequest
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
            'username' => [
                'required', 
                'string', 
                'min:3', 
                'max:16', 
                'regex:/^[a-zA-Z0-9_]+$/',
                'unique:users,username'
            ],
            'valid_id_image' => 'required|image|mimes:png,jpg,jpeg,svg',
            'id_type' => 'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'username.regex' => 'The username may only contain letters, numbers, and underscores.'
        ];
    }
}
