<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseModuleRequest extends FormRequest
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
            'courseModule.title' => ['required'],
            'courseModule.title_kz' => ['required'],
            'courseModule.text' => ['required'],
            'courseModule.text_kz' => ['required'],
            'courseModule.lecture' => ['required'],
            'courseModule.lecture_kz' => ['required'],
            'courseModule.course_part_id' => ['required'],
        ];
    }
}
