<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CuttingPermitRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'tree_id' => [
                'required',
                'exists:trees,id', // Assuming your table is 'trees'
            ],
            'reason' => [
                'required',
                'string',
                'min:10',
                'max:1000',
            ],
            'document' => [
                'required',
                'file',
                'mimes:pdf,jpeg,jpg,png',
                'max:5120', // 5MB in kilobytes (5 * 1024)
            ],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // Tree selection validation messages
            'tree_id.required' => 'Please select a registered tree.',
            'tree_id.exists' => 'The selected tree is not valid or does not exist.',
            
            // Reason validation messages
            'reason.required' => 'Please provide a reason for cutting the tree.',
            'reason.string' => 'The reason must be a valid text.',
            'reason.min' => 'The reason must be at least 10 characters long.',
            'reason.max' => 'The reason cannot exceed 1000 characters.',
            
            // Document validation messages
            'document.required' => 'Please upload a supporting document.',
            'document.file' => 'The uploaded file is not valid.',
            'document.mimes' => 'The document must be a PDF file or image (JPG, PNG) only.', // Updated message
            'document.max' => 'The document size cannot exceed 5MB.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'tree_id' => 'registered tree',
            'reason' => 'reason for cutting',
            'document' => 'supporting document',
        ];
    }
}