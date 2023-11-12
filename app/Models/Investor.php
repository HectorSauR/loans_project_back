<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Investor extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "available",
        "profits",
        'user_id'
    ];

    public function invests(): HasMany
    {
        return $this->hasMany(Invest::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function is_active(): bool
    {
        $active = false;

        if (!is_null($this->engaged)) {
            $active = true;
        }

        return $active;
    }

    public function getBalance()
    {
        return ($this->available ?? 0) + ($this->profit ?? 0);
    }

    public function delete()
    {
        if ($this->is_active()) {
            throw new \Exception("No se puede eliminar un inversor que tiene préstamos activos");
        }

        $balance = $this->getBalance();

        Invest::createNewInvest([
            'total' => $balance,
            'investor_id' => $this->id,
            'kind' => 'out',
            'detail' => "Invesor dado de baja"
        ]);

        $this->status = 0;
        $this->save();
    }
}
