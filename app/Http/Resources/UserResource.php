<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    /**
     * @OA\Schema(
     *     schema="UserResource",
     *      type="object",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="name", type="string", example="Señor Pepe (admin)"),
     *     @OA\Property(property="email", type="string", example="pepe@pepe.com"),
     *     @OA\Property(property="role", type="string", example="Admin"),
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role->name,
        ];
    }
}
