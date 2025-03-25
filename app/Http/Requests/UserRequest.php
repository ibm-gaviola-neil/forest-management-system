<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            "department_id" => 'nullable',
            "designation" => 'nullable',
            "last_name" => 'required',
            "email" => 'required|unique:users,email|email',
            "username" => 'required|min:6|unique:users,username',
            "role" => 'required',
            "password" => 'required|confirmed|min:6',
            "password_confirmation" => 'required',
        ];
    }
}
