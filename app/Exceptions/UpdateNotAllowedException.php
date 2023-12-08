<?php
namespace App\Exceptions;

use Exception;


class UpdateNotAllowedException extends Exception
{
    protected $code = 400;
}