<?php

namespace App\Http\Resources\V1\Payment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "total" => $this->total,
            "kind" => $this->kind,
            "created_at" => $this->created_at,
            "debtor" => $this->debtor
        ];
    }
}
