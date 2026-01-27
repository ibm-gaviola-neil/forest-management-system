<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditApplicantRequest extends FormRequest
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
        $userId = $this->route('user')->id;
        return [
            "first_name" => 'required',
            "last_name" => 'required',
            "middle_name" => 'nullable',
            "email" => 'required|email|unique:users,email,' . $userId,
            "contact_number" => ['required','regex:/^(09|\+639)\d{9}$/', 'min:11'],
            "birth_date" => 'required',
            "address" => 'required',
        ];
    }
}
