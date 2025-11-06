<?php

namespace App\Http\Resources;

use App\Models\UserSalaRole;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function Laravel\Prompts\error;

class UserSalaRoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    /**
     * @OA\Schema(
     *     schema="UserSalaRoleResource",
     *     type="object",
     *     @OA\Property(property="sala_id", type="integer", example=1),
     *     @OA\Property(property="sala_name", type="string", example="Sala 1"),
     *     @OA\Property(property="role_id", type="integer", example=1),
     *     @OA\Property(property="role_name", type="string", example="Admin")
     * )    
     */
    public function toArray(Request $request): array
    {    
        return [
            'sala_id' => $this->sala_id,
            'sala_name' => $this->sala->name,
            'role_id' => $this->role_id,
            'role_name' => $this->role->name,            
        ];
    }
}
