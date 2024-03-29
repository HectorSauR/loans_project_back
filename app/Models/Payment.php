<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

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
        $debtor = Debtor::find($data['debtor_id']);
        $loans = $debtor->loans(true)->get();

        if (count($loans) < 1) {
            throw new \Exception("No hay pagos pendientes", 400);
        }

        $payment = Payment::create($data);

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
                $loan->finish();
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

    public function delete()
    {
        $payments = LoanPayments::where('payment_id', $this->id)->get();

        foreach ($payments as $payment) {
            $payment->delete();
        }

        parent::delete();
    }
}
