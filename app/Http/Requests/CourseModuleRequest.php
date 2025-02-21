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
            'courseModule.goal' => ['nullable'],
            'courseModule.goal_kz' => ['nullable'],
            'courseModule.task' => ['nullable'],
            'courseModule.task_kz' => ['nullable'],
            'courseModule.result' => ['nullable'],
            'courseModule.result_kz' => ['nullable'],
            'courseModule.content' => ['nullable'],
            'courseModule.content_kz' => ['nullable'],
            'courseModule.course_part_id' => ['required'],
            'courseModule.duration_hours' => ['required'],

        ];
    }
}
