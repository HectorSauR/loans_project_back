<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        "total",
        "remaining",
        "interest",
        "interest_generated",
        "deadline",
        "ended_date",
        "guarantee",
        "kind",
        "investor_id",
        "debtor_id"
    ];

    public function debtor(): BelongsTo
    {
        return $this->belongsTo(Debtor::class);
    }

    public function investor(): BelongsTo
    {
        return $this->belongsTo(Investor::class);
    }

    public function isActive(): bool
    {
        return !$this->ended_date;
    }

    public static function createNewLoan(array $data): Loan
    {
        $debtor = Debtor::find($data["debtor_id"]);

        //TODO: check more to start a new loan
        foreach ($debtor->loans as $loan) {
            if ($loan->isActive()) {
                throw new \Exception(
                    "No se puede crear una nueva deuda con una deuda activa"
                );
            }
        }

        $loan = Loan::create($data);

        return $loan;
    }
}
