<?php

namespace App\Http\Resources\V1\Debtor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanDebtorResource extends JsonResource
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
            'remaining' => $this->remaining,
            'interest' => $this->interest,
            'interest_generated' => $this->interest_generated,
            'deadline' => $this->deadline,
            'estimated_end_date' => $this->estimated_end_date,
            'ended_date' => $this->ended_date,
            'guarantee' => $this->guarantee,
            'kind' => $this->kind,
            'investor' => $this->investor,
            'created_at' => $this->created_at
        ];
    }
}
