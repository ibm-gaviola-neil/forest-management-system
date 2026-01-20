<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileImageRequest extends FormRequest
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
            "profile_image" => "required|mimes:png,jpg,jpeg|max:1024",
        ];
    }

    public function messages()
    {
        return [
            "profile_image.required" => "The profile image field is required.",
            "profile_image.mimes" => "The profile image must be a file of type: png, jpg, jpeg.",
        ];
    }
}
