<?php

namespace App\Http\Resources;

use App\Models\Sala;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="InvitacionResource",
 *      type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="invitador", type="string", example="Señor Pepe (admin)"),
 *    @OA\Property(property="invitado", type="string", example="Señor Juan (user)"),
 *     @OA\Property(property="sala", type="string", example="Sala 1"),
 * )
 */
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
        $invitadoName = User::find($this->user_invitado_id)->name;
        $salaName = Sala::find($this->sala_id)->name;

        return [
            'id' => $this->id,
            'invitador' => $invitadorName,
            'invitado' => $invitadoName,
            'sala' => $salaName,
        ];
    }
}
