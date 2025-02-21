<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseLessonRequest extends FormRequest
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
            'lesson.title' => ['nullable'],
            'lesson.title_kz' => ['nullable'],
            'lesson.goal' => ['nullable'],
            'lesson.goal_kz' => ['nullable'],
            'lesson.task' => ['nullable'],
            'lesson.task_kz' => ['nullable'],
            'lesson.result' => ['nullable'],
            'lesson.result_kz' => ['nullable'],
            'lesson.content' => ['nullable'],
            'lesson.content_kz' => ['nullable'],
            'lesson.course_module_id' => ['nullable'],
        ];
    }
}
