<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        "total",
        "kind",
        "debtor_id",
    ];

    public function debtor(): BelongsTo
    {
        return $this->belongsTo(Debtor::class);
    }

    static function createNewPayment($data)
    {
        $payment = Payment::create($data);

        $loans = $payment->debtor->activeLoans();
        $totalPayment = $payment->total;

        foreach ($loans as $loan) {
            //restar el total del pago al prestamo más viejo.
            $remaining = $loan->remaining;

            $diff = abs($remaining - $totalPayment);

            if ($remaining > $totalPayment) {
                $loan->remaining = $diff;
                $loan->save();
                $paid = $totalPayment;
                $totalPayment = 0;
            } else {
                $loan->remaining = 0;
                $loan->save();
                $paid = $remaining;
                $totalPayment = $diff;
            }

            LoanPayments::create([
                "total" => $paid,
                "payment_id" => $payment->id,
                "loan_id" => $loan->id
            ]);

            if ($totalPayment == 0) {
                break;
            }
        }

        return $payment;
    }
}
