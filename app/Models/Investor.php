<?php

namespace App\Models;

use App\Models\Scopes\UserScoped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Investor extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScoped());
    }

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

    public function reduceBalance(float $amount): void
    {
        if ($this->available > $amount) {
            $this->available -= $amount;
            $this->save();
            return;
        }

        $difference = abs($this->available - $amount);

        $this->available = 0;
        $this->profit -= $difference;
        $this->save();
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
