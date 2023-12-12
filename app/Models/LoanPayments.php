<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanPayments extends Model
{
    use HasFactory;

    protected $fillable = [
        "total",
        "payment_id",
        "loan_id",
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function delete()
    {
        $loan = $this->loan;

        $loan->remaining += $this->total;
        $loan->save();

        parent::delete();
    }
}
