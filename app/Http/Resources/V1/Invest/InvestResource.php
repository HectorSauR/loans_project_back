<?php

namespace App\Http\Resources\V1\Invest;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvestResource extends JsonResource
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
            'total' => $this->total,
            'investor_id' => $this->investor,
            'kind' => $this->kind,
            'details' => $this->details,
            'created_at' => $this->created_at,
        ];
    }
}
