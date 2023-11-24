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
}
