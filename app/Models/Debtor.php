<?php

namespace App\Models;

use App\Models\Scopes\UserScoped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Debtor extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScoped());
    }

    protected $fillable = [
        "name",
        "address",
        "max_active_loans",
        "user_id"
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activeLoans()
    {
        $loans = $this->loans()
            ->whereNull("ended_date")
            ->orderBy('created_at')
            ->get();

        return $loans;
    }

    public static function getForUser(User $user)
    {
        return Debtor::where("user_id", $user->id)->get();
    }
}
