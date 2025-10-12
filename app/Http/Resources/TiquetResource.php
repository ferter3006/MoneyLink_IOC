<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TiquetResource extends JsonResource
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
            'user_name' => $this->user->name,
            'category_name' => $this->category->name,
            'es_ingreso' => $this->es_ingreso,
            'description' => $this->description,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
        ];
    }
}
