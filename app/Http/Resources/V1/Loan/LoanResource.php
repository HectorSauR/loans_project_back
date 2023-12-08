<?php

namespace App\Http\Resources\V1\Loan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
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
            'debtor' => $this->debtor,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
