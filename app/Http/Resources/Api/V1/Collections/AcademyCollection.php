<?php

namespace App\Http\Resources\Api\V1\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AcademyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($academy) {
                return [
                    'id' => $academy->id,
                    'name' => $academy->name,
                    'description' => $academy->description,
                    'address' => $academy->address,
                    'phone' => $academy->phone,
                    'email' => $academy->email,
                    'state' => $academy->state->name,
                    'rating' => $academy->rating,
                ];
            })->toArray(),
            'links' => [
                'first' => $this->url(1),
                'last' => $this->url($this->lastPage()),
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'path' => $this->path(),
                'per_page' => $this->perPage(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
            ],
            'status' => 'success',
        ];
    }
}
