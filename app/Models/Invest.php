<?php

namespace App\Models;

use App\Exceptions\InactiveInvestorException;
use App\Exceptions\InsuficientBalanceException;
use App\Exceptions\UpdateNotAllowedException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Decimal;

class Invest extends Model
{
    use HasFactory;

    protected $fillable = [
        "total",
        "investor_id",
        "kind"
    ];

    public function investor(): BelongsTo
    {
        return $this->belongsTo(Investor::class);
    }


    public static function createNewInvest(array $data): Invest
    {
        $investor = Investor::findOrFail($data["investor_id"]);

        if (
            $data["kind"] ?? "in" == "out"
            and $investor->getBalance() < $data["total"]
        ) {
            throw new \Exception("No se retirar más dinero del que se tiene disponible");
        }

        $invest = Invest::create($data);

        if ($invest->kind == "out") {
            $investor->available -= $invest->total;
        } else {
            $investor->available += $invest->total;
        }

        $investor->save();

        return $invest;
    }

    public function update(array $attributes = [], array $options = [])
    {
        // Cargar el inversor relacionado
        $this->investor;

        // Validar si el inversor está inactivo
        if ($this->investorIsInactive()) {
            throw new InactiveInvestorException("No se puede modificar a un inversor inactivo");
        }

        // Comprobar si ha pasado una semana desde la creación
        if ($this->isUpdateAllowedAfterOneWeek()) {
            throw new UpdateNotAllowedException("No se puede modificar el registro después de una semana.");
        }

        $totalSaved = $this->total;
        $totalIncoming = $attributes["total"];
        $isDifferentKind = isset($attributes["kind"]) ? $attributes["kind"] == $this->kind : false;
        $difference = abs($totalSaved - $totalIncoming);
        $investorAvailable = $this->investor->available;

        $this->total = $totalIncoming;

        if ($isDifferentKind == 0) {
            $sum = $totalSaved + $totalIncoming;

            if ($attributes['kind'] == "out") {
                if ($sum > $investorAvailable) {
                    throw new InsuficientBalanceException("Saldo insuficiente para efectuar la modificación.", 400);
                }

                $this->investor->available -= $sum;
            } else {
                $this->investor->available += $sum;
            }
        } else {
            if ($totalSaved < $totalIncoming) {
                $this->investor->available += $difference;
            } else {
                if ($difference > $investorAvailable) {
                    throw new InsuficientBalanceException("Saldo insuficiente para efectuar la modificación.", 400);
                }
                $this->investor->available -= $difference;
            }
        }

        $this->save();
        $this->investor->save();
    }

    private function investorIsInactive()
    {
        return $this->investor->status == 0;
    }

    private function isUpdateAllowedAfterOneWeek()
    {
        $oneWeekAgo = now()->subWeek();
        return $this->created_at <= $oneWeekAgo;
    }

    public function user()
    {
        return $this->investor->user;
    }
}
