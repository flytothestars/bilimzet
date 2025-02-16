<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'full_name' => $this->full_name,
            'email' => $this->email,
            'address' => $this->address,
            'position' => $this->position,
            'company_name' => $this->company_name,
            'photo' => $this->attachment('profilePhoto')->first(),
            'diploma' => $this->attachment('profileDocument')->get(),
            'iin' => $this->iin,
            'phone' => $this->phone,
            'is_verification' => $this->is_verification
        ];
    }
}
