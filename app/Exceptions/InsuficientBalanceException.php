<?php
namespace App\Exceptions;

use Exception;

class InsuficientBalanceException extends Exception
{
    protected $code = 400;
}
