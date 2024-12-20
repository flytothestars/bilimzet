<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'course.title' => ['required'],
            'course.title_kz' => ['required'],
            'course.author_fio' => ['required'],
            'course.author_fio_kz' => ['required'],
            'course.author_position' => ['required'],
            'course.author_position_kz' => ['required'],
            'course.desc_text' => ['required'],
            'course.desc_text_kz' => ['required'],
            'course.listeners_category_text' => ['required'],
            'course.listeners_category_text_kz' => ['required'],
            'course.goals_text' => ['required'],
            'course.goals_text_kz' => ['required'],
            'course.tasks_text' => ['required'],
            'course.tasks_text_kz' => ['required'],
            'course.organization_text' => ['required'],
            'course.organization_text_kz' => ['required'],
            'course.speciality_id' => ['required'],
        ];
    }
}
