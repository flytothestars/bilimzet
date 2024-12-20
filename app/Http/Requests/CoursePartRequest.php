<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoursePartRequest extends FormRequest
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
            'coursePart.title' => ['required'],
            'coursePart.title_kz' => ['required'],
            'coursePart.duration_hours' => ['required'],
            'coursePart.price_kzt' => ['required'],
            'coursePart.course_id' => ['required'],
        ];
    }
}
