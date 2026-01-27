<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChainsawRequest extends FormRequest
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
        $isEdit = $this->route('chainsaw') !== null;
        $chainsaw = $this->route('chainsaw');
        
        // Check if there are already uploaded requirements
        $hasExistingRequirements = false;
        if ($isEdit && $chainsaw) {
            $hasExistingRequirements = \App\Models\ChainsawRequirement::where('chainsaw_request_id', $chainsaw->id)->exists();
        }
        
        // Set document validation rules based on context
        $documentRules = [];
        
        // For new registrations or edits without uploaded documents, require documents
        if (!$isEdit || !$hasExistingRequirements) {
            $documentRules = [
                'documents' => [
                    'required',
                    'array',
                    'min:1',
                ],
                'documents.*' => [
                    'required',
                    'file',
                    'mimes:pdf,jpeg,jpg,png',
                    'max:10240', // 10MB in kilobytes
                ],
            ];
        } else {
            // For edits with existing documents, make documents optional
            $documentRules = [
                'documents' => [
                    'nullable',
                    'array',
                ],
                'documents.*' => [
                    'nullable',
                    'file',
                    'mimes:pdf,jpeg,jpg,png',
                    'max:10240', // 10MB in kilobytes
                ],
            ];
        }
        
        // Base rules that apply to both new registrations and edits
        $baseRules = [
            'serial_number' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'bar_length' => 'required|numeric',
            'engine_displacement' => 'required|numeric|min:2',
            'date_acquisition' => 'required|date',
            'description' => 'nullable|string',
        ];
        
        // Merge base rules with document rules
        return array_merge($baseRules, $documentRules);
    }

    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'serial_number.required' => 'Serial Number is required.',
            'serial_number.string' => 'Serial Number must be a string.',
            'serial_number.max' => 'Serial Number must not exceed 255 characters.',
            'brand.required' => 'Brand is required.',
            'brand.string' => 'Brand must be a string.',
            'brand.max' => 'Brand must not exceed 255 characters.',
            'model.required' => 'Model is required.',
            'model.string' => 'Model must be a string.',
            'model.max' => 'Model must not exceed 255 characters.',
            'bar_length.required' => 'Bar Length is required.',
            'bar_length.numeric' => 'Bar Length must be a numeric value.',
            'engine_displacement.required' => 'Engine Displacement is required.',
            'engine_displacement.numeric' => 'Engine Displacement must be a numeric value.',
            'engine_displacement.min' => 'Engine Displacement must be at least 2cc.',
            'date_acquisition.required' => 'Date of Acquisition is required.',
            'date_acquisition.date' => 'Date of Acquisition must be a valid date.',
            'description.string' => 'Description must be a string.',
            
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
     * Get data except documents.
     *
     * @return array
     */
    public function getDataExceptDocuments()
    {
        return collect($this->validated())->except(['document', 'documents'])->toArray();
    }
    
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Convert empty documents array to null if no files were actually selected
        if ($this->has('documents') && is_array($this->documents) && count(array_filter($this->documents)) === 0) {
            $this->merge(['documents' => null]);
        }
    }
}