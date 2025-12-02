<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TreeRequest extends FormRequest
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
            "treeId" => "required",
            "treeType" => "required",
            "datePlanted" => "required|date",
            "height" => "required|numeric",
            "diameter" => "required|numeric",
            "location" => "required",
            "description" => "required",
        ];
    }
}
