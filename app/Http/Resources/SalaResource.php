<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    /**
     * @OA\Schema(
     *     schema="SalaResource",
     *      type="object",
     *     @OA\Property(property="id", type="integer", example=1),
     *     @OA\Property(property="name", type="string", example="Sala 1"),
     *     @OA\Property(property="ingresos", type="integer", example=1000),
     *     @OA\Property(property="gastos", type="integer", example=500),
     *     @OA\Property(property="balance", type="integer", example=500),
     *     @OA\Property(property="tiquets", type="array", @OA\Items(ref="#/components/schemas/TiquetResource"))
     * )
     */
    public function toArray(Request $request): array
    {

        $ingresos = $this->tiquets->where('es_ingreso', true)->sum('amount');
        $gastos = $this->tiquets->where('es_ingreso', false)->sum('amount');
        $balance = $ingresos - $gastos;

        return [
            'id' => $this->id,
            'name' => $this->name,                        
            'ingresos' => $ingresos,
            'gastos' => $gastos,
            'balance' => $balance,
            'tiquets' => TiquetResource::collection($this->tiquets)
            
        ];
    }
    

}
