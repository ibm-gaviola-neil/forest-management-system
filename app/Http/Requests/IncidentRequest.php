<?php

namespace App\Http\Requests;

use App\Models\IncidentAttachment;
use Illuminate\Foundation\Http\FormRequest;

class IncidentRequest extends FormRequest
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
        $isEdit = $this->route('incident') !== null;
        $attachments = IncidentAttachment::where('incident_id', $this->route('incident')->id ?? 0)->exists();

        $rules = [
            // Reporter Information
            'is_anonymous'   => ['nullable', 'boolean'],

            'reporter_name'  => ['required', 'string', 'max:255'],
            'reporter_email' => ['nullable', 'email', 'max:255', 'required_if:is_anonymous,0'],
            'reporter_phone' => ['nullable', 'string', 'max:20', 'required_if:is_anonymous,0'],
            
            // Incident Details
            'incident_type' => 'required|in:illegal_logging,unauthorized_cutting,forest_fire,wildlife_poaching,encroachment,other',
            'incident_date' => 'required|date|before_or_equal:now',
            'severity' => 'required|integer|in:1,2,3,4',
            'priority' => 'required|integer|in:1,2,3',
            'description' => 'required|string|min:10|max:2000',
            
            // Location Information
            'location' => 'required|string|max:500',
            'landmark' => 'nullable|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        
            
            // Related Records (optional for authenticated users)
            'tree_id' => 'nullable|exists:trees,id',
            'permit_id' => 'nullable|exists:permits,id',
            
            // Admin Fields (for authenticated users only)
            'status' => 'nullable|integer|in:1,2,3,4,5',
            'assigned_to' => 'nullable',
            'admin_notes' => 'nullable|string|max:1000',

            'related_tree_id' => 'nullable|string|max:1000',
            'related_permit_id' => 'nullable|string|max:1000',
        ];

        if($isEdit && $attachments) {
            $rules['incident_id'] = 'required|integer|exists:incidents,id';

            $rules['attachments'] = 'nullable|array|max:10';
            $rules['attachments.*'] = 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,pdf,doc,docx,txt|max:10240';
        }else{
            $rules['attachments'] = 'required|array|max:10';
            $rules['attachments.*'] = 'file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,pdf,doc,docx,txt|max:10240';
        }

        return $rules;
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'reporter_name.required' => 'Reporter name is required.',
            'reporter_email.required' => 'Email address is required.',
            'reporter_email.email' => 'Please enter a valid email address.',
            'incident_type.required' => 'Please select an incident type.',
            'incident_type.in' => 'Please select a valid incident type.',
            'incident_date.required' => 'Incident date is required.',
            'incident_date.before_or_equal' => 'Incident date cannot be in the future.',
            'severity.required' => 'Please select a severity level.',
            'severity.in' => 'Please select a valid severity level.',
            'priority.required' => 'Please select a priority level.',
            'priority.in' => 'Please select a valid priority level.',
            'description.required' => 'Description is required.',
            'description.min' => 'Description must be at least 10 characters.',
            'description.max' => 'Description cannot exceed 2000 characters.',
            'location.required' => 'Location is required.',
            'latitude.required' => 'Please mark the incident location on the map.',
            'longitude.required' => 'Please mark the incident location on the map.',
            'latitude.between' => 'Invalid latitude coordinates.',
            'longitude.between' => 'Invalid longitude coordinates.',
            'attachments.attachments' => 'Upload atleast one attachement.',
            'attachments.max' => 'You can upload a maximum of 10 files.',
            'attachments.*.mimes' => 'File must be an image, video, or document (jpg, jpeg, png, gif, mp4, mov, avi, pdf, doc, docx, txt).',
            'attachments.*.max' => 'Each file must not exceed 10MB.',
            'tree_id.exists' => 'Selected tree does not exist.',
            'permit_id.exists' => 'Selected permit does not exist.',
            'status.in' => 'Please select a valid status.',
            'assigned_to.exists' => 'Selected staff member does not exist.',
            'admin_notes.max' => 'Admin notes cannot exceed 1000 characters.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Custom validation: If anonymous is checked, reporter name should be optional
            if ($this->input('is_anonymous')) {
                // Remove required validation for reporter_name if anonymous
                $rules = $validator->getRules();
                if (isset($rules['reporter_name'])) {
                    $rules['reporter_name'] = str_replace('required|', 'nullable|', $rules['reporter_name'][0] ?? '');
                }
            }

            // Custom validation: Ensure at least one contact method if not anonymous
            if (!$this->input('is_anonymous')) {
                if (empty($this->input('reporter_email')) && empty($this->input('reporter_phone'))) {
                    $validator->errors()->add('reporter_email', 'Either email or phone number is required for non-anonymous reports.');
                }
            }
        });
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'reporter_name' => 'reporter name',
            'reporter_email' => 'email address',
            'reporter_phone' => 'phone number',
            'incident_type' => 'incident type',
            'incident_date' => 'incident date',
            'severity' => 'severity',
            'priority' => 'priority',
            'description' => 'description',
            'location' => 'location',
            'landmark' => 'landmark',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'attachments' => 'attachments',
            'tree_id' => 'related tree',
            'permit_id' => 'related permit',
            'status' => 'status',
            'assigned_to' => 'assigned staff',
            'admin_notes' => 'admin notes',
        ];
    }

    public function getDataExceptDocuments()
    {
        return collect($this->validated())->except(['attachments'])->toArray();
    }
}