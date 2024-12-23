<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseModuleLectureRequest extends FormRequest
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
            'courseModuleLecture.title' => ['required'],
            'courseModuleLecture.title_kz' => ['required'],
            'courseModuleLecture.content' => ['nullable'],
            'courseModuleLecture.content_kz' => ['nullable'],
            'courseModuleLecture.course_module_id' => ['nullable'],
        ];
    }
}
