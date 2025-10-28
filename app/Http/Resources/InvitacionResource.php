<?php

namespace App\Http\Resources;

use App\Models\Sala;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvitacionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $invitadorName = User::find($this->user_invitador_id)->name;
        $salaName = Sala::find($this->sala_id)->name;

        return [
            'id' => $this->id,
            'invitador' => $invitadorName,
            'sala' => $salaName,
        ];
    }
}
