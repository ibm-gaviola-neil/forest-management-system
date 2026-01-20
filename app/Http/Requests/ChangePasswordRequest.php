<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'current_password' => ['required', 'string'],
        ];
        
        // Check if the current password is correct before validating new password
        if ($this->isCurrentPasswordCorrect()) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed', 'different:current_password'];
            $rules['password_confirmation'] = ['required', 'string'];
        }
        
        return $rules;
    }

    /**
     * Check if the current password is correct.
     *
     * @return bool
     */
    protected function isCurrentPasswordCorrect(): bool
    {
        if (!$this->has('current_password')) {
            return false;
        }
        
        return Hash::check(
            $this->input('current_password'), 
            auth()->user()->password
        );
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->isCurrentPasswordCorrect()) {
                $validator->errors()->add(
                    'current_password', 
                    'The provided current password is incorrect.'
                );
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'current_password.required' => 'The current password is required.',
            'password.required' => 'The new password is required.',
            'password.different' => 'The new password must be different from your current password.',
            'password.min' => 'The new password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password_confirmation.required' => 'The password confirmation is required.',
        ];
    }
}
