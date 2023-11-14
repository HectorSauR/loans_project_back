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
        "interest",
        "deadline",
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

    public static function createNewLoan(array $data, User $user): Loan
    {
        $debtor = Debtor::find($data["debtor_id"]);

        $max_loans = $user->max_active_loans;

        $active_loans = $debtor->loans->whereNull("ended_date")->count();

        if ($active_loans >= $max_loans) {
            throw new \Exception(
                "Préstamos activos superados."
            );
        }

        $loan = Loan::create($data);

        return $loan;
    }

    public function update(array $data = [], array $options = [])
    {
        
    }
}
