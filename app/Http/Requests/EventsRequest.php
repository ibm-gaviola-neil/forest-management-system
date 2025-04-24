<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventsRequest extends FormRequest
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
            'title' => 'required|max:255',
            'content' => 'required',
            'display_start_date' => 'required',
            'display_end_date' => 'required'
        ];
    }

    public function messages(){
        return [
            'title.required' => 'Please enter title of the event.',
            'title.max' => 'Title maximum of 255 character.',
            'content.required' => 'Please enter content of the event.',
            'display_start_date.required' => 'Please enter display start date.',
            'display_end_date.required' => 'Please enter display end date.'
        ];
    }
}
