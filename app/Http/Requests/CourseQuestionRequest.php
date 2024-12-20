<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseQuestionRequest extends FormRequest
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
            'courseQuestion.title' => ['required'],
            'courseQuestion.title_kz' => ['required'],
            'courseQuestion.correct_answer' => ['required'],
            'courseQuestion.correct_answer_kz' => ['required'],
            'courseQuestion.incorrect_answer_1' => ['required'],
            'courseQuestion.incorrect_answer_1_kz' => ['required'],
            'courseQuestion.incorrect_answer_2' => ['required'],
            'courseQuestion.incorrect_answer_2_kz' => ['required'],
            'courseQuestion.incorrect_answer_3' => ['required'],
            'courseQuestion.incorrect_answer_3_kz' => ['required'],
            'courseQuestion.course_test_id' => ['required'],

        ];
    }
}
