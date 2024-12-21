<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_kz' => $this->title_kz,
            'category' => $this->getCategory(),
            'text' => $this->text,
            'text_kz' => $this->text_kz,
            'author_id' => $this->author,
            'is_published' => $this->is_published,
            'document' => $this->attachment('articleDocument')->get(),
        ];
    }
}
