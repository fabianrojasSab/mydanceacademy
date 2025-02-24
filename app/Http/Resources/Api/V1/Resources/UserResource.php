<?php

namespace App\Http\Resources\Api\V1\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'phone'         => $this->phone,
            'hiring_date'   => $this->hiring_date,
            'state'         => $this->state,
        ];
    }
}
