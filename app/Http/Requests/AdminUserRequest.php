<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequest extends FormRequest
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
        // Get the user ID from the route parameter (for edit) or null (for create)
        $userId = $this->route('user') ? $this->route('user')->id : null;

        return [
            "first_name" => 'required|string|max:255',
            "last_name" => 'required|string|max:255',
            "middle_name" => 'nullable|string|max:255',
            "email" => 'required|email|unique:users,email' . ($userId ? ',' . $userId : ''),
            "contact_number" => ['required', 'regex:/^(09|\+639)\d{9}$/', 'min:11'],
            "birth_date" => 'required|date',
            "address" => 'required|string',
            "username" => 'required|string',
            "role" => 'required|string|in:admin,denr',
            "password" => 'required|confirmed|min:10'
        ];
    }
}
