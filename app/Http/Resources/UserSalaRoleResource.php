<?php

namespace App\Http\Resources;

use App\Models\Role;
use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSalaRoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'sala_id' => $this->sala_id,
            'sala_name' => Sala::find($this->sala_id)->name,            
            'role_name' => Role::find($this->role_id)->name
        ];
    }
}
