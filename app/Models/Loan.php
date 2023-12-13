<?php

namespace App\Models;

use App\Exceptions\InsuficientBalanceException;
use App\Exceptions\UpdateNotAllowedException;
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
        "deadline",
        "guarantee",
        "kind",
        "investor_id",
        "debtor_id",
        "estimated_end_date"
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

        $max_loans = $debtor->max_active_loans;

        $active_loans = $debtor->loans->whereNull("ended_date")->count();

        if ($active_loans >= $max_loans) {
            throw new \Exception("Préstamos activos superados.", 400);
        }

        $investor = Investor::find($data["investor_id"]);

        $investorBalance = $investor->getBalance();

        if (!($investorBalance >= $data["total"])) {
            throw new InsuficientBalanceException(
                "Insuficiente dinero disponible del inversor.",
                400
            );
        }

        $investor->reduceBalance($data["total"]);

        $data["remaining"] = $data["total"];

        $loan = Loan::create($data);

        return $loan;
    }

    public function update(array $data = [], array $options = [])
    {

        if ($this->isUpdateAllowedAfter24Hours()) {
            throw new UpdateNotAllowedException("No se puede modificar el registro después de 24 horas.");
        }

        if (!array_key_exists("total", $data)) {
            parent::update($data, $options);
            return;
        }

        $investorBalance = $this->investor->getBalance();
        $newTotal = (float)$data["total"];
        $difference = abs($this->total - $newTotal);

        if ($this->total > $newTotal) {
            $this->investor->available += $difference;
        } else if ($this->total != $newTotal) {
            if ($difference > $investorBalance) {
                throw new InsuficientBalanceException("Saldo insuficiente para efectuar la modificación.", 400);
            }

            $this->investor->available -= $difference;
        }

        $this->investor->save();
        parent::update($data, $options);
    }

    private function isUpdateAllowedAfter24Hours()
    {
        $oneDayAgo = now()->subDay();
        return $this->created_at <= $oneDayAgo;
    }

    public function finish()
    {
        $this->ended_date = now();
        $this->save();
    }
}
