<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'article.title' => ['nullable'],
            'article.title_kz' => ['nullable'],
            'article.category' => ['nullable'],
            'article.text' => ['nullable'],
            'article.text_kz' => ['nullable'],
            'article.is_published' => ['nullable'],
        ];
    }
}
