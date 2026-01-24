<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'treeId' => [
                'required',
                $this->route('tree') 
                    ? Rule::unique('trees', 'treeId')->ignore($this->route('tree')->id)
                    : Rule::unique('trees', 'treeId')
            ],
            "treeType" => "required",
            "datePlanted" => "required|date",
            "height" => "required|numeric",
            "diameter" => "required|numeric",
            "location" => "required",
            "description" => "nullable",
            "lattitude" => "required",
            "longitude" => "required",
            "land_mark" => "required"
        ];
    }

    public function messages()
    {
        return [
            'treeId.required' => 'The Tree ID field is required.',
            'treeId.unique' => 'The Tree ID has already exists.',
            'treeType.required' => 'The Tree Type field is required.',
            'datePlanted.required' => 'The Date Planted field is required.',
            'datePlanted.date' => 'The Date Planted must be a valid date.',
            'height.required' => 'The Height field is required.',
            'height.numeric' => 'The Height must be a number.',
            'diameter.required' => 'The Diameter field is required.',
            'diameter.numeric' => 'The Diameter must be a number.',
            'location.required' => 'The Location field is required.',
            'description.required' => 'The Description field is required.',
            'lattitude.required' => 'The Lattitude field is required.',
            'longitude.required' => 'The Longitude field is required.',
        ];
    }
}
