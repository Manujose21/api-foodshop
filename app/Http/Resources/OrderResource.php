<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'products' => $this->products,
            'total_price' => $this->total_price,
            'user' => new UserResource($this->whenLoaded('user')),
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
