<?php

namespace App\Http\Resources\V1\Debtor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DebtorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $active = $request->query('active') ? true : false;

        return [
            "id" => $this->id,
            "name" => $this->name,
            "address" => $this->address,
            "max_active_loans" => $this->max_active_loans,
            "loans" => LoanDebtorResource::collection($this->loans($active)->get())
        ];
    }
}
