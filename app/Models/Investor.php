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
}
