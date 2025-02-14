<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseSpecialityRequest extends FormRequest
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
            'courseSpeciality.title' => ['required'],
            'courseSpeciality.title_kz' => ['required'],
            'courseSpeciality.description' => ['required'],
            'courseSpeciality.description_kz' => ['required'],
            'courseSpeciality.category' => ['required'],
            'courseSpeciality.picture_background' => ['required'],
        ];
    }
}
