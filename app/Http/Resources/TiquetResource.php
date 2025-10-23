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
    /**
     * @OA\Schema(
     *     schema="TiquetResource",
     *      type="object",     
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="user_name", type="string", example="Señor Pepe (admin)"),
     *     @OA\Property(property="category_name", type="string", example="Comida"),
     *     @OA\Property(property="es_ingreso", type="boolean", example=true),
     *     @OA\Property(property="description", type="string", example="Pizza"),
     *     @OA\Property(property="amount", type="integer", example=1000),
     *     @OA\Property(property="created_at", type="string", example="2023-01-01 00:00:00"),
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,            
            'sala_id' => $this->sala_id,
            'user_name' => $this->user->name,
            'category_name' => $this->category->name,
            'es_ingreso' => $this->es_ingreso,
            'description' => $this->description,
            'amount' => $this->amount,
            'created_at' => $this->created_at,            
        ];
    }
}
