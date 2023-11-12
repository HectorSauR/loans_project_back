<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Debtor extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "address",
        "user_id"
    ];


    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }


    public function activeLoans(): array
    {
        $loans = $this->loans()
            ->whereNull("ended_date")
            ->get();

        return array($loans);
    }
}
