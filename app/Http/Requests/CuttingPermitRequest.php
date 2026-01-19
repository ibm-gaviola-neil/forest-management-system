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
            // Remove the single document validation as it's now multiple
            'documents' => [
                'required',
                'array', // Ensure it's an array of files
                'min:1',  // At least one file
            ],
            'documents.*' => [
                'required',
                'file',
                'mimes:pdf,jpeg,jpg,png',
                'max:10240', // 10MB in kilobytes
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
            
            // Multiple documents validation messages
            'documents.required' => 'Please upload at least one supporting document.',
            'documents.array' => 'The supporting documents are not in the correct format.',
            'documents.min' => 'Please upload at least one supporting document.',
            
            // Individual document validation messages
            'documents.*.required' => 'Each document is required.',
            'documents.*.file' => 'One of the uploaded files is not valid.',
            'documents.*.mimes' => 'All documents must be PDF files or images (JPG, JPEG, PNG) only.',
            'documents.*.max' => 'Each document size cannot exceed 10MB.',
            
            // Keep the old document messages for backward compatibility
            'document.required' => 'Please upload a supporting document.',
            'document.file' => 'The uploaded file is not valid.',
            'document.mimes' => 'The document must be a PDF file or image (JPG, PNG) only.',
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
            'document' => 'supporting document', // Keep for backward compatibility
            'documents' => 'supporting documents',
            'documents.*' => 'supporting document',
        ];
    }

    /**
     * Get data except documents.
     */
    public function getDataExceptDocuments()
    {
        return collect($this->validated())->except(['document', 'documents'])->toArray();
    }
}