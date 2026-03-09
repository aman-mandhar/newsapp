<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEpaperEditionRequest extends FormRequest
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
            'edition_name' => ['required', 'string', 'max:255'],
            'issue_date' => ['required', 'date'],
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:51200'], // 50MB max
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'edition_name.required' => 'Edition name is required.',
            'issue_date.required' => 'Issue date is required.',
            'issue_date.date' => 'Issue date must be a valid date.',
            'pdf.required' => 'PDF file is required.',
            'pdf.mimes' => 'File must be a PDF.',
            'pdf.max' => 'PDF file size must not exceed 50MB.',
        ];
    }
}
