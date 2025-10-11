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
