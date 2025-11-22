<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="SalaObjectiveResource",
 *     type="object",
 *     example={"11-2025": "150.00"}
 * )
 */
class SalaObjectiveResource extends JsonResource
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
