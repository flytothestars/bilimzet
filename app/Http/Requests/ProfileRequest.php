<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'user.full_name' => 'string|max:255',
            'user.iin' => 'string|max:255',
            'user.address' => 'nullable|string|max:255',
            'user.position' => 'nullable|string|max:255',
            'user.company_name' => 'nullable|string|max:255',
            'user.email' => 'nullable|email|max:255|unique:users,email',
			// 'user.photo' => 'nullable|file|max:2048',
            'user.diplomas' => 'nullable|array',
			'user.diplomas.*' => 'nullable|file|mimes:pdf,doc,docx,txt,jpg,jpeg,png|max:10240',
        ];
    }
}
