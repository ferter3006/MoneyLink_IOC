<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaObjectiveResource extends JsonResource
    /**
     * @OA\Schema(
     *     schema="SalaObjectiveResource",
     *     type="object",
     *     @OA\Property(property="mes", type="string", example="11-2025"),
     *     @OA\Property(property="amount", type="number", format="float", example=150.00)
     * )
     */
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            $this->date->format('m-Y') => $this->amount,            
        ];
    }
}
