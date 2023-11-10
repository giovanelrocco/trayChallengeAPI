<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vendedor_id' => $this->vendedor_id,
            'valor' => (float) $this->valor,
            'data_venda' => $this->data_venda,
            'comissao' => (float) $this->comissao,
            'percentual_comissao' => (float) $this->percentual_comissao,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
