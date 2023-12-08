<?php
namespace App\Exceptions;

use Exception;

class InactiveInvestorException extends Exception
{
    protected $code = 400;
}