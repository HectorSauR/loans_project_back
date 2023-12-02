<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanPayments extends Model
{
    use HasFactory;

    protected $fillable = [
        "total",
        "payment_id",
        "loan_id",
    ];
}
